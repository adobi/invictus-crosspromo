<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Platforms extends MY_Model 
{
    protected $_name = "cp_platform";
    protected $_primary = "id";
    
    public function fetchAvailableForGame($gameId) 
    {
      if (!$gameId) return false;
      
      return $this->execute("select p.* from $this->_name p where p.id not in (select platform_id from c_game_platform where game_id = $gameId)");
    }
    
    public function initFromApi()
    {
      
      $data = $this->invictus->setUri(INVICTUS_API_URI)->setAction('platforms')->get(true);
      
      if (!$data) return false;
      
      foreach ($data as &$item) {
        unset($item['image']);
        unset($item['image_name']);
        $item['url'] = $this->sanitizer->sanitize_title_with_dashes($item['name']);
      }
      
      $this->truncate();
      
      $this->bulk_insert($data);
      
    }
    
    public function findByName($name, $type) 
    {
      $name = strtolower($name);
      
      $platform = false;
      
      if ($name === 'ios') {
        if ($type === 'phone') $platform = 'iphone';
        
        if ($type === 'tablet') $platform = 'ipad';
      }
      
      if ($name === 'android') {
        if ($type === 'phone') $platform = 'android phone';
        
        if ($type === 'tablet') $platform = 'android tablet';
      }

      if ($name === 'amazon') {
        if ($type === 'phone') $platform = 'amazon';
        
        if ($type === 'tablet') $platform = 'amazon';
      }

      
      $result = $this->execute("select id from $this->_name where lcase(name) like '%$platform%'");
      
      //dump($result);
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'found platform:' . json_encode($result) . "\r\n", FILE_APPEND);
      if (empty($result)) return false;
      
      return $result[0];
    }        
}