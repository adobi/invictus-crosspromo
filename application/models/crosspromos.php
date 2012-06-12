<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Crosspromos extends MY_Model 
{
    protected $_name = "cp_crosspromo";
    protected $_primary = "id";
    
    public function fetchByGame($id, $type) 
    {
      if (!$id) return false;

      $result = $this->fetchRows(
        array('columns'=>array('cp_crosspromo.*', 'if(cp_crosspromo.promo_price=0, NULL, promo_price) as promo_price_or_null '),
              'where'=>array("base_game_id"=>$id, 'list_id'=>$type), 
              'join'=>array(
                array('table'=>'cp_game_platform', 'condition'=>'cp_game_platform.id = promo_game_id', 'columns'=>array('cp_game_platform.id as gp_id', 'if(cp_game_platform.is_new=0, NULL, 1) as is_new', 'if(cp_game_platform.is_update=0, NULL, 1) as is_update', 'if(cp_game_platform.price=0, NULL, price) as price', 'cp_game_platform.long_url')),
                array('table'=>'cp_game', 'condition'=>'cp_game.id = cp_game_platform.game_id  and is_active = 1', 'columns'=>array('cp_game.name, cp_game.logo, cp_game.url')),  
                array('table'=>'cp_platform', 'condition'=>'cp_platform.id = cp_game_platform.platform_id', 'columns'=>array('cp_platform.name as platform_name')),  
                array('table'=>'cp_crosspromo_type', 'condition'=>'cp_crosspromo_type.id = cp_crosspromo.type_id', 'columns'=>array('cp_crosspromo_type.name as type_name', 'cp_crosspromo_type.image as type_image', 'cp_crosspromo_type.text as type_text')),  
              ),
              'order'=>array('by'=>"order", 'dest'=>'asc'))
      , false, true);
      //dump($result);
      return $result;
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