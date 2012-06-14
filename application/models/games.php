<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Games extends MY_Model 
{
    protected $_name = "cp_game";
    protected $_primary = "id";

    public function initFromApi()
    {
      
      $data = $this->invictus->setUri(INVICTUS_API_URI)->setAction('games')->get(true);
      
      if (!$data) return false;
      
      $d = array();
      foreach ($data as $item) {
        
        $d[] = array(
          'id'=>$item['id'], 
          'name'=>$item['name'], 
          'url'=>$item['url'], 
          'logo'=>$this->_getImageFromUrl($item['logo'], $item['logo_name']), 
          'is_active'=>$item['is_active'], 
          'category_id'=>$item['category_id'],
          'short_description'=>$item['short_description'],
        );
      }
      
      $this->truncate();
      
      $this->bulk_insert($d);
    }
    
    private function _getImageFromUrl($url, $name)
    {
      if ($url && $name) {
        
        $imageBinary = file_get_contents($url);
        
        $this->config->load('upload');
        
        $image = time().'_'.$name;
        file_put_contents($this->config->item('upload_path').$image, $imageBinary);
        
        return $image;
      } 
      
      return false;
    }    
    
    public function fetchAllWithPlatforms()
    {
      $items = $this->fetchAll(array('order'=>array('by'=>'order', 'dest'=>'asc')));
      
      if (!$items) return false;
      
      $this->load->model('Gameplatforms', 'gameplatform');
      
      foreach ($items as $item) {
        $item->platforms = $this->gameplatform->fetchIdsForGame($item->id);
      }
      //dump($items); die;
      return $items;
    }
    
    public function fetchActive()
    {
      return $this->fetchRows(array('where'=>array('is_active'=>1),'order'=>array('by'=>'order', 'dest'=>'asc')));
    }
    
    public function fetchAllActiveWithPlatforms()
    {
      $items = $this->fetchActive();
      
      if (!$items) return false;
      
      $this->load->model('Gameplatforms', 'gameplatform');
      
      foreach ($items as $item) {
        $item->platforms = $this->gameplatform->fetchIdsForGame($item->id);
      }
      //dump($items); die;
      return $items;
    }
    
    public function fetchLastReleased() 
    {
      $result = $this->fetchRows(array('where'=>array('is_active'=>1), 'order'=>array('by'=>'released', 'dest'=>'desc'), 'limit'=>1, 'offset'=>0), true);
      
      if (!$result) return false;
      
      $this->load->model('Gameplatforms', 'gameplatforms');
      
      $result->platforms = $this->gameplatforms->fetchForGame($result->id);

      $this->load->model('Gamevideos', 'videos');
      $result->video = $this->videos->fetchOnSectionForGame($result->id, 'on_all_games');
      
      return $result;
    }
    
    public function activate($id) 
    {
      if (!$id) return false;
      
      return $this->update(array('is_active'=>1), $id);
    }
    
    public function inactivate($id) 
    {
      if (!$id) return false;
      
      return $this->update(array('is_active'=>null), $id);
    }

    public function fetchForLayout($section)
    {
      $result = $this->fetchRows(
        array('where'=>array('is_active'=>1, "is_$section"=>1), 
              'order'=>array('by'=>"order_$section", 'dest'=>'asc'))
      );
      
      $d = array();
      $max = ($section === 'on_mainpage' ? 4 : 5);
      
      $this->load->model('Analytics', 'analytics');
      
      for ( $i=0; $i < $max; $i++ ) {
        $d[$i] = $this->_getByOrder($result, "order_$section", $i);   

        if ($d[$i]) {
          $d[$i]->analytics = $this->analytics->fetchByGame($d[$i]->id);
        }
      }
      
      return $d;
    }
    
    public function fetchForMainpageCarousel()
    {
      $result = $this->fetchForLayout('on_mainpage');
      
      if (!$result) return false;
      
      $this->load->model('Gamevideos', 'videos');
      
      foreach ($result as $item) {
        if ($item)
         $item->video = $this->videos->fetchOnSectionForGame($item->id, 'on_mainpage');
      }
      
      return $result;
    }
    
    public function fetchByUrl($url, $allInfo = false) 
    {
      $result = $this->fetchRows(array('where'=>array('url'=>$url)), true);
      
      if (!$result) return false;
      
      $this->load->model('Gameplatforms', 'gameplatforms');
      
      $result->platforms = $this->gameplatforms->fetchForGame($result->id);

      $this->load->model('Gamevideos', 'videos');
      
      if ($allInfo) {
        
        $this->load->model('Gameimages', 'images');
        $result->images = $this->images->fetchForGame($result->id, true);
        $result->images_is_empty = $this->images->orderedArrayIsEmpty($result->images);

        $this->load->model('Gamevideos', 'videos');
        $result->videos = $this->videos->fetchForGame($result->id);        
        $result->videos_is_empty = $this->videos->orderedArrayIsEmpty($result->videos);        
        
        $this->load->model('Crosspromos', 'promo');
        $result->crosspromo = $this->promo->fetchByGame($result->id);
        $result->crosspromo_is_empty = $this->promo->orderedArrayIsEmpty($result->crosspromo);

        $result->video = $this->videos->fetchOnSectionForGame($result->id, 'on_product_page');
      } else {
        $result->video = $this->videos->fetchOnSectionForGame($result->id, 'on_all_games');
      }
      
      $this->load->model('Analytics', 'analytics');
      $result->analytics = $this->analytics->fetchByGame($result->id);
      //dump($result);
      return $result;      
    }
    
    public function getMeta($url) 
    {
      $game = $this->fetchByUrl($url);
      
      if (!$game) return false;
      
      $this->load->model('Meta', 'meta');
      
      return $this->meta->find($game->meta_id);      
    }
    
    public function fetchWithCrosspromo()
    {
      return $this->execute("select g.*, (select count(id) from ic_crosspromo where base_game_id = g.id ) as count from $this->_name g where g.is_active=1");
    }
    
    public function setupAnalytics($id) 
    {
      if (!$id) return false;
      /*      
        főoldalról hero a product page-re	home	játék neve	hero	fájl_név	timestamp	Banner	Click																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
        főoldalról teaser a product page-re	home	játék neve	teaser	fájl_név	timestamp	Banner	Click																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
        főoldalról footer a product page-re	home	játék neve	footer	fájl_név	timestamp	Link	Click																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
        all product-ról a product page-re	all_product	játék neve	button		timestamp	Inbound link	Click	
        more games menüből a product page-re	more_games	játék neve	icon	fájl_név	timestamp	Banner	Click																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
      */      
      
      $game = $this->find($id);
      
      if (!$game) return false;
      
      $this->load->model('Analytics', 'analytics');
      
      $this->analytics->delete(array('game_id'=>$id));
      
      $data = array();
      
      $hero = array(
        'game_id'=>$game->id,
        'type'=>'hero',
        'ga_category'=>'Banner',
        'ga_action'=>'Click',
        'ga_value'=>1,
        'ga_label'=>'Home - '.$game->name.' - Hero - '.strip_ext($game->hero_image),
      );
      
      $teaser = array(
        'game_id'=>$game->id,
        'type'=>'teaser',
        'ga_category'=>'Banner',
        'ga_action'=>'Click',
        'ga_value'=>1,
        'ga_label'=>'Home - '.$game->name.' - Teaser - '.strip_ext($game->teaser_image),
      );
      
      $footer = array(
        'game_id'=>$game->id,
        'type'=>'footer',
        'ga_category'=>'Link',
        'ga_action'=>'Click',
        'ga_value'=>1,
        'ga_label'=>'Footer - ' . $game->name . ' - Footer - '.time(),
      );
      
      $moreGames = array(
        'game_id'=>$game->id,
        'type'=>'more_games',
        'ga_category'=>'Banner',
        'ga_action'=>'Click',
        'ga_value'=>1,
        'ga_label'=>'More games - '.$game->name.' - Icon - '.strip_ext($game->logo),
      );
      
      $allGames = array(
        'game_id'=>$game->id,
        'type'=>'all_games',
        'ga_category'=>'Inbound link',
        'ga_action'=>'Click',
        'ga_value'=>1,
        'ga_label'=>'All products - '.$game->name.' - Button - '.time(),
      );
      $data[] = $hero;
      $data[] = $teaser;
      $data[] = $footer;
      $data[] = $moreGames;
      $data[] = $allGames;
      
      $this->analytics->bulk_insert($data);
    }
    
    public function gameUrlExists($url) 
    {
      if (!$url) return false;
      
      if ($url === 'roc') return 'race-of-champions';
      
      $all = $this->fetchActive();
      
      if (!$all) return false;
      
      foreach ($all as $item) {
        if ($item->url === $url) return $url;
        
        if (strpos($url, $item->url) !== false || strpos($item->url, $url) !== false) {
          return $item->url;
        }
      }
      
      return false;
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