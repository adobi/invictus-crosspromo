<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Crosspromos extends MY_Model 
{
    protected $_name = "cp_crosspromo";
    protected $_primary = "id";
    
    public function find($id, $isXML = false)  
    {
      $item = parent::find($id, $isXML);
      
      if (!$item) return $item;
      
      
      if (!$item->description) {
        $this->load->model('Gameplatforms', 'gp');
        
        $gp = $this->gp->find($item->promo_game_id);
        
        $this->load->model('Games', 'game');
        
        $game = $this->game->find($gp->game_id);
        
        $item->description = $game->short_description;
      }
      
      return $item;
    }
    
    public function fetchByGame($id, $list, $params = false) 
    {
      if (!$id || !$list) return false;
      
      $result = $this->fetchRows(
        array('columns'=>array(
                'cp_crosspromo.id', 'cp_crosspromo.base_game_id', 'cp_crosspromo.promo_game_id', 'cp_crosspromo.order', 'cp_crosspromo.ga_category', 'cp_crosspromo.ga_action', 'cp_crosspromo.ga_label', 'cp_crosspromo.ga_value', 'cp_crosspromo.ga_noninteraction', 
                'cp_crosspromo.created', 'cp_crosspromo.until', 'cp_crosspromo.list_id', 'cp_crosspromo.type_id', 'cp_crosspromo.promo_price', 'cp_crosspromo.title', 
                '(if (cp_crosspromo.description is null || cp_crosspromo.description = "", cp_game.crosspromo_description, cp_crosspromo.description)) as description', 
                'if(cp_crosspromo.promo_price=0, NULL, promo_price) as promo_price_or_null '),
              'where'=>array("base_game_id"=>$id, 'list_id'=>$list), 
              'join'=>array(
                array('table'=>'cp_game_platform', 'condition'=>'cp_game_platform.id = promo_game_id', 'columns'=>array(
                  'cp_game_platform.id as gp_id', 
                  'if(cp_game_platform.is_new=0 || ISNULL(cp_game_platform.is_new), NULL, 1) as is_new', 
                  'if(cp_game_platform.is_update=0 || ISNULL(cp_game_platform.is_update), NULL, 1) as is_update', 
                  'if(cp_game_platform.price=0, NULL, price) as price', 
                  'cp_game_platform.platform_id',
                  'cp_game_platform.game_id',
                  'cp_game_platform.long_url', 
                  'cp_game_platform.currency',
                  'cp_game_platform.min_os_version',
                  'cp_game_platform.version',
                )),
                array('table'=>'cp_game', 'condition'=>'cp_game.id = cp_game_platform.game_id  and is_active = 1', 'columns'=>array('cp_game.name', 'cp_game.logo', 'cp_game.url', 'cp_game.category_id')),  
                array('table'=>'cp_platform', 'condition'=>'cp_platform.id = cp_game_platform.platform_id', 'columns'=>array('cp_platform.name as platform_name')),  
                array('table'=>'cp_crosspromo_type', 'condition'=>'cp_crosspromo_type.id = cp_crosspromo.type_id', 'columns'=>array('cp_crosspromo_type.name as type_name', 'cp_crosspromo_type.image as type_image', 'cp_crosspromo_type.text as type_text')),  
              ),
              'order'=>array('by'=>"order", 'dest'=>'asc'))
      , false, true);
      
      if ($params) {

        if (!isset($params['platform'])) return $result;

        $this->load->model('Users', 'user');
        
        $user = $this->user->findBy('device_id', $params['device']);
        
        //dump($user); die;
        //dump($params);
        if (!$user) return $result;
        
        $this->load->model('UserGames', 'usergames');
        //$userGames = $this->usergames->fetchBy('user_id', $user->id);
        
        $listSize = count($result);
        $holes = array();
        
        $platform = array();
        if (strtolower($params['platform']) === 'ios') {
          if (strtolower($params['type']) === 'phone') {
            $platforms = array(2);
          }
          
          if (strtolower($params['type']) === 'tablet') {
            $platforms = array(5);
          }
        }
        
        if (strtolower($params['platform']) === 'android') {
          if (strtolower($params['type']) === 'phone') {
            $platforms = array(7);
          }
          
          if (strtolower($params['type']) === 'tablet') {
            $platforms = array(8);
          }
        }
        
        $criteria = $params;
        $criteria['user_id'] = $user->id;
        $criteria['platforms'] = $platforms;
        
        if ($result) {
          
          foreach ($result as $index=>$item) {
            
            /**
             * ha az listsitem min_os_version-je nagyobb mint a kapott os verzio, akkor kivenni es mast valasztani helyette.
             * valasztas: ami nincs meg a jatekosnak, es azonos os-sel rendelkezik mint ami a keresben jon, es a min_os_version kisebb mint az kapott os verzio
             *
             * @author Dobi Attila
             */
             
             if (in_array($item->platform_id, $platforms) && !$this->isOsVersionOk($item->min_os_version, $params['os'])) {
               
               $result[$index] = -1;
               
               $holes[$index] = $item;
               //$result[$index] = $this->findSimilarGame($criteria, $item);
              }
             
             /**
              * ha megvan neki a jatek, es a listaban levo jatek verzioszama nagyobb mint a parameterkent kapott verzio akkor marad a listaba
              *
              * @author Dobi Attila
              */
             if ($ownedGame = $this->usergames->hasGame($user->id, $item->gp_id)) {
  
               if ($ownedGame->game_version < $item->version) {
                 $item->is_updated = true;
               } else {
                 /**
                  * ha megvan neki a jatek, es a listaban levo jatek verziszama = a parameterkent kapott verzioval akkor kikerul a listabol
                  * valasztas: olyan jatek, ami nincs meg a jatekosnak es a kategoriaja megegyezik a kikerult jatek kategoriajaval
                  *
                  * @author Dobi Attila
                  */  
                 $result[$index] = -2; 
                 
                 //$result[$index] = $this->findSimilarGame($criteria, $item);
                 $holes[$index] = $item;
               }
             } 
          }
        } else {
          $holes = range(0,4);
        }

        $result = $this->findSimilarGame($criteria, $result, $holes, $list);
      }
      
      return $result;
    }
    
    /**
     * keres egy megfelelo jatekot a kapot parametereknek megfeleloen
     * - nincs meg az adott jatekosnak
     * - nem szerepelt a listaban
     * - os tipus megfelelo
     * - os verzio megfelelo
     *
     * @param array $params a keresben kapott parameterek
     * @param array $result a list lyukakkal
     * @param array $holes a lyukakat tartalmazo tomb: [lyuk_index] = elem a $resultbol
     * @param int $listId melyik listarol van szo
     * @return array
     * @author Dobi Attila
     */
    public function findSimilarGame($params, $result, $holes, $listId) 
    {
      //$item->removed = true;

      if (!$holes) return $result;
      
      $sql = "select 
        /*cp_game.*,*/
                cp_game.name, cp_game.logo, cp_game.url, cp_game.category_id, cp_game.crosspromo_description, 
                cp_game_platform.id as promo_game_id, 
                cp_game_platform.id as gp_id,
                if(cp_game_platform.is_new=0 || ISNULL(cp_game_platform.is_new), NULL, 1) as is_new,
                if(cp_game_platform.is_update=0 || ISNULL(cp_game_platform.is_update), NULL, 1) as is_update,
                if(cp_game_platform.price=0, NULL, price) as price,
                cp_game_platform.platform_id,
                cp_game_platform.game_id,
                cp_game_platform.long_url,
                cp_game_platform.currency,
                cp_game_platform.min_os_version,
                cp_game_platform.version,
                cp_platform.name as platform_name
              from cp_game
                join cp_game_platform on cp_game_platform.game_id = cp_game.id
                join cp_platform on cp_platform.id = cp_game_platform.platform_id
              where 
								cp_game_platform.id not in (select game_id from cp_user_game where user_id = ".$params['user_id'].")
								and cp_game_platform.id not in (select promo_game_id from cp_crosspromo where list_id = ".$listId.")
								and cp_game_platform.platform_id in (".join(',', $params['platforms']).")
								and cp_game_platform.min_os_version < '".$params['os']."'
              order by rand()
              limit ".count($holes);
      $return = $this->execute($sql);
      
      if (!$return) return $result;
      
      $holesValues = array_values($holes);
      $holesKeys = array_keys($holes);
      
      /**
       * az lyukak potlasat szolgalo elemek analitikaja
       *
       * @author Dobi Attila
       */
      foreach ($return as $res) {
        
        if ($res) {
          
          $res->ga_value = 1;
          $res->ga_action = 'Click';
          $res->ga_noninteraction = '';
          
          $this->load->model('Crosspromolists', 'list');
          $list = $this->list->find($listId);
          $res->ga_category = 'Crosspromo - ' . $list->name;
          
          $res->ga_label = $res->name . ' - ' . $res->version . ' - ' . $list->name . ' - ' . time();
          
          $res->inserted = 1;
        }
      }
      
      /**
       * az uj elemeket visszapakoljuk a listaba a megfelelo helyre
       *
       * @author Dobi Attila
       */
      foreach ($holesKeys as $index=>$value) {
        if (isset($return[$index])) {
          
          $result[$value] = $return[$index];
        }
        else {
          unset($result[$value]);
        }
      }
      //dump($result);
      /**
       * rendezzuk a listat az is_new szerint, hogy azok legyenek elol
       *
       * @author Dobi Attila
       */
      usort($result, array('Crosspromos', 'isNewComparator'));
       
      return $result;
    }
    
    public static function isNewComparator($a, $b)
    {
      if (is_null($a->is_new)) $a->is_new = 0;
      if (is_null($b->is_new)) $b->is_new = 0;
      //dump($a); dump($b);
      return intval($a->is_new) < intval($b->is_new);
    }
    
    /**
     * osszehasonlitja a listaelem min_os_version-jet a keresben kapott os_version-nel
     *
     * @param string $itemMinOsVersion
     * @param string $requestOsVersion 
     * @return boolean true ha az item min_os_version-je kisebb mint a keresben kapott os_version
     * @author Dobi Attila
     */
    public function isOsVersionOk($itemMinOsVersion, $requestOsVersion)
    {
      if (!$itemMinOsVersion || !$requestOsVersion) return true;
      
      return $itemMinOsVersion <= $requestOsVersion;
    }
    
    //public function setupAnalytics($srcGameId, $destGameId, &$return)
    public function setupAnalytics($id)
    {
      $crosspromo = $this->find($id);
      
      if (!$crosspromo) return false;
      
      $this->load->model('Crosspromolists', 'list');
      
      $list = $this->list->find($crosspromo->list_id);
      
      if (!$list) return false;
      
      $data = array();
      $data['ga_value'] = 1;
      $data['ga_action'] = 'Click';
      $data['ga_category'] = 'Crosspromo - ' . $list->name;
      
      // {Game Name} - {Version} - {OS} - {Offer Name} - {Timestamp}
      
      $this->load->model('Gameplatforms', 'gp');
      $gp = $this->gp->find($crosspromo->promo_game_id);
      
      if (!$gp) return false;
      
      $this->load->model('Games', 'game');
      
      $game = $this->game->find($gp->game_id);
      
      if (!$game) return false;
      
      $this->load->model('Crosspromotypes', 'types');
      
      $type = $this->types->find($crosspromo->type_id);
      
      $data['ga_label'] = $game->name . ' - ' . ($type ? $type->name : 'No type') . ' - '  . time();
      
      //dump($data);
      $this->update($data, $id);
    }
    
    private function _getByOrder($items, $column, $order) 
    {
      foreach( $items as $item ) {
        if ($item->$column == $order) {
          return $item;
        }
      }
      
      return false;
    }    
    
}