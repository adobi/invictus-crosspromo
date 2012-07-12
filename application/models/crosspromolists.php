<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Crosspromolists extends MY_Model 
{
    protected $_name = "cp_crosspromo_list";
    protected $_primary = "id";
    
    public function isFree($listId) 
    {
      if (!$listId) return false;
      
      $list = $this->find($listId);
      
      return !$list ? false : strpos(strtolower($list->name), 'free') !== false;
    }
    
    public function fetchForGame($id) 
    {
      if (!$id) return false;
      
      //$result = $this->fetchRows(array('where'=>array('game_id'=>$id, 'is_active'=>1),'order'=>array('by'=>'order', 'dest'=>'asc')));
      
      $sql = "select $this->_name.* from $this->_name where game_id = $id and is_active = 1 and (select count(id) from cp_crosspromo where list_id = $this->_name.id) != 0 order by `order` asc";
      //dump($sql); die;
      $result = $this->execute($sql);
      
      return $result;
    }
    
    public function hasGameList($gamePlatformId) 
    {
      //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'hasGameList parameter:' . $gamePlatformId . "\r\n", FILE_APPEND);
      if (!$gamePlatformId) return 0;
      
      //$result = $this->findBy('game_id', $gamePlatformId);
      
      $result = $this->fetchForGame($gamePlatformId);
      
      //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'hasGameList result:' . json_encode($result) . "\r\n", FILE_APPEND);
      
      if (count($result)) return 1;
      
      return 0;
    }
    
    /**
     * atmasolja a $listId listat a $games jatekokhoz
     *
     * @param string $listId 
     * @param array $games 
     * @return boolean true ha sikeres volt, false egyebkent
     * @author Dobi Attila
     */
    public function copyList($listId, $games)
    {
      if (!$listId || empty($games)) return false;
      
      $list = $this->find($listId);
      
      if (!$list) return false;
      
      $this->load->model('Crosspromos', 'promo');
      
      $listItems = $this->promo->fetchBy('list_id', $list->id);
      
      /**
       * uj listat felvinni a $list adataival, masolni a kepet
       *
       * @author Dobi Attila
       */
      
      $listCopy = array(
        'name'=>$list->name,
        'image'=>$this->copyImage($list->image)
      );
      //dump($listItems); die;
      foreach ($games as $game) {
        $listCopy['game_id'] = $game;
        
        $listCopyId = $this->insert($listCopy);
        
        foreach ($listItems as $item) {
          $itemCopy = array(
            'list_id'=>$listCopyId,
            'base_game_id'=>$game,
            'promo_game_id'=>$item->promo_game_id,
            'order'=>$item->order,
            'until'=>$item->until,
            'type_id'=>$item->type_id,
            'description'=>$item->description,
            'promo_price'=>$item->promo_price,
            'title'=>$item->title
          );
          
          $itemCopyId = $this->promo->insert($itemCopy);
          
          $this->promo->setupAnalytics($itemCopyId);
        }
      }
      
      return true;
    }
    
    public function copyImage($image) 
    {
      if (!$image) return false;
      
      $this->load->config('upload');
      $dir = $this->config->item('upload_path');
      //dump($this->config); die;
      $newImage = time().$image;
      
      @copy($dir.$image, $dir.$newImage);
      
      return $newImage;
    }
}