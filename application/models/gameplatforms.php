<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Gameplatforms extends MY_Model 
{
    protected $_name = "cp_game_platform";
    protected $_primary = "id";
    
    public function getActualPrice($id)
    {
      if (!$id) return 0;
      
      $item = $this->find($id);
      
      if (!$item) return 0;
      
      $this->load->model('Crosspromos', 'promo');
      
      $promos = $this->promo->fetchBy('promo_game_id', $id);
      
      if (!$promos) return $item->price ? $item->price : 0;
      
      return $promos[0]->promo_price ? $promos[0]->promo_price : 0;
    }
    
    public function findByGameAndPlatform($game, $platform) 
    {
      
      if (!$game || !$platform) return false;
      
      return current($this->fetchRows(array('where'=>array('game_id'=>$game, 'platform_id'=>$platform))));
    }

    public function initFromApi()
    {
      
      $data = $this->invictus->setUri(INVICTUS_API_URI)->setAction('game_platforms')->get(true);
      
      //dump($data); die;
      
      if (!$data) return false;
      
      $this->truncate();
      
      $this->bulk_insert($data);
    }    
    
    public function fetchForGame($gameId, $withAnalytics = true) 
    {
      if (!$gameId) return false;
      
      $result = $this->fetchRows(array('join'=>array(array('table'=>'cp_platform', 'condition'=>'cp_platform.id = cp_game_platform.platform_id', 'columns'=>array('name', 'image'))), 'where'=>array('game_id'=>$gameId)));
      
      return $result;
    }
    
    public function fetchAllWithGameAndPlatform()
    {
      $sql = "select gp.*, g.name as game_name, p.name as platform_name, g.logo from cp_game_platform gp join cp_game g on gp.game_id = g.id and g.is_active = 1 join cp_platform p on gp.platform_id = p.id order by game_name asc";
      //dump($sql); die;
      return $this->execute($sql);
    }
    
    public function fetchIdsForGame($gameId)
    {
      $platforms = $this->fetchForGame($gameId);
      
      if (!$platforms) return false;
      
      $return = array();
      foreach ($platforms as $item) $return[] = $item->platform_id;
      
      return $return;
    }
    
    public function deleteByGame($gameId) 
    {
      if (!$gameId) return false;
      
      return $this->delete(array('game_id'=>$gameId));
    }
    
    // not used
    public function insertPlatformsForGame($gameId, $platforms) 
    {
      if (!$gameId || !$platforms) return false;
      
      $this->load->model('Games', 'game');
      $this->load->model('Platforms', 'platform');
      
      $game = $this->game->find($gameId);
      
      if (!$game) return false;
      
      foreach ($platforms as $p) {
        $platform = $this->model->find($p);
        $this->insert(array(
          'game_id'=>$gameId, 
          'platform_id'=>$p,
          'ga_category'=>'Store',
          'ga_action'=>'Click',
          'ga_value'=>1,
          'ga_label'=>$game->name . ' - ' . $platform->name,
        ));
      }
      
      return true;
    }
    
    public function setupAnalytics($id)
    {
      if (!$id) return false;
      
      $item = $this->find($id);
      
      if (!$item) return false;
      
      $locations = array('all_games', 'product_page');
      
      $this->load->model('Games', 'games');
      $this->load->model('Platforms', 'platforms');
      
      $game = $this->games->find($item->game_id);
      $platform = $this->platforms->find($item->platform_id);
      
      if (!$game || !$platform) return false;
      
      $this->load->model('Gameplatformanalytics', 'analytics');
      
      $data = array();
      $data['game_platform_id'] = $id;
      $data['ga_value'] = 1;
      $data['ga_action'] = 'Click';
      $data['ga_category'] = 'Outbound link';
      
      $data['ga_label'] = 'All product - ' . $platform->name . ' - button - ' . time();
      $data['location'] = $locations[0];
      $this->analytics->insert($data);
      
      $data['ga_label'] = $game->name . ' - ' . $platform->name . ' - button - ' . time();
      $data['location'] = $locations[1];
      $this->analytics->insert($data);
      
      return true;
    }
    
    public function updateAnalytics($platform) 
    {
      if (!$platform) return false;
      
      $this->load->model('Gameplatformanalytics', 'analytics');
      
      $gamePlatforms = $this->fetchBy('platform_id', $platform);
      
      if (!$gamePlatforms) return false;
      
      foreach ($gamePlatforms as $gp) {
        $this->analytics->delete(array('game_platform_id'=>$gp->id));
        
        $this->setupAnalytics($gp->id);
      }
      
      return true;
    }
}

  