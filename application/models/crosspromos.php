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
        array('where'=>array("base_game_id"=>$id, 'list_id'=>$type), 
              'join'=>array(
                array('table'=>'cp_game_platform', 'condition'=>'cp_game_platform.id = promo_game_id'),
                array('table'=>'cp_game', 'condition'=>'cp_game.id = cp_game_platform.game_id  and is_active = 1', 'columns'=>array('cp_game.name, cp_game.logo, cp_game.url')),  
                array('table'=>'cp_platform', 'condition'=>'cp_platform.id = cp_game_platform.platform_id', 'columns'=>array('cp_platform.name as platform_name')),  
              ),
              'order'=>array('by'=>"order", 'dest'=>'asc'))
      );
      //dump($result);
      return $result;
    }
    
    public function setupAnalytics($srcGameId, $destGameId, &$return)
    {
      /*
        product page cross promo a másik product page-re	játék_neve	játék neve	cross_promo	fájl_név	timestamp	Outbound link	Click																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								

      */
      
      $this->load->model('Games', 'games');
      $src = $this->games->find($srcGameId);
      $dest = $this->games->find($destGameId);
      
      $return['ga_category'] = 'Inbound link';
      //$return['ga_label'] = $src->name.' - '.$dest->name.' - Crosspromo - '.strip_ext($src->logo);
      $return['ga_action'] = 'Click';
      $return['ga_value'] = 1;      
      
      return $return;
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