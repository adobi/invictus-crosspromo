<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Crosspromos extends MY_Model 
{
    protected $_name = "cp_crosspromo";
    protected $_primary = "id";
    
    public function fetchByGame($id, $list, $params = false) 
    {
      if (!$id || !$list) return false;
      
      $result = $this->fetchRows(
        array('columns'=>array('cp_crosspromo.*', 'if(cp_crosspromo.promo_price=0, NULL, promo_price) as promo_price_or_null '),
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

        if (!$result || !isset($params['platform'])) return $result;

        $this->load->model('Users', 'user');
        
        $user = $this->user->findBy('device_id', $params['device']);
        
        if (!$user) return $result;
        
        $this->load->model('UserGames', 'usergames');
        //$userGames = $this->usergames->fetchBy('user_id', $user->id);
        
        $listSize = count($result);
        $holes = array();
        
        if (strtolower($params['platform']) === 'ios') $platforms = array(1,2,5);
        
        if (strtolower($params['platform']) === 'android') $platforms = array(7,8);
        
        foreach ($result as $index=>$item) {
          
          /**
           * ha az item min_os_version-je nagyobb mint a kapott os verzio, akkor kivenni es mast valasztani helyette.
           * valasztas: ami nincs meg a jatekosnak, es a min_os_version kisebb mint az kapott os verzio
           *
           * @author Dobi Attila
           */
           
           if (in_array($item->platform_id, $platforms) && !$this->isOsVersionOk($item->min_os_version, $params['os'])) {
             
             $result[$index] = -1;
             
             $holes[] = $index;
           }
           
           /**
            * ha megvan neki a jatek, es a listaban levo jatek verzioszama nagyobb mint a parameterkent kapott verzio akkor marad a listaba
            *
            * @author Dobi Attila
            */
           if ($game = $this->usergames->hasGame($user->id, $item->gp_id)) {
             
             if ($game->game_version < $item->version) {
               $item->is_updated = true;
             } else {
               /**
                * ha megvan neki a jatek, es a listaban levo jatek verziszama = a parameterkent kapott verzioval akkor kikerul a listabol
                * valasztas: olyan jatek, ami nincs meg a jatekosnak es a kategoriaja megegyezik a kikerult jatek kategoriajaval
                *
                * @author Dobi Attila
                */  
               $result[$index] = -2; 
             }
           } 
        }
      }
      
      //dump($result); die;
      return $result;
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
      /*
        product page cross promo a másik product page-re	játék_neve	játék neve	cross_promo	fájl_név	timestamp	Outbound link	Click																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								

      */
      /*
      $this->load->model('Games', 'games');
      $src = $this->games->find($srcGameId);
      $dest = $this->games->find($destGameId);
      
      $return['ga_category'] = 'Inbound link';
      //$return['ga_label'] = $src->name.' - '.$dest->name.' - Crosspromo - '.strip_ext($src->logo);
      $return['ga_action'] = 'Click';
      $return['ga_value'] = 1;      
      
      return $return;
      */
      
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
      
      $data['ga_label'] = $game->name . ' - ' . $gp->version . ' - ' . $list->name . ' - ' . time();
      
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