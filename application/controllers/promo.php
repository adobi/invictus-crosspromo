<?php 

if (! defined('BASEPATH')) exit('No direct script access');

require_once(APPPATH.'core/Promo_Controller'.EXT);

class Promo extends Promo_Controller 
{
  
  public function index()
  {
    $data = array();
  
    $this->load->model('Gameplatforms', 'model');
    
    $data['games'] = $this->model->fetchAllWithGameAndPlatform();    
    
    $this->template->build('promo/index', $data);
  }
  
  public function show() 
  {
    $data = array();
    $params = $this->uri->uri_to_assoc(3);
    
    $data['params'] = $params;

    $this->load->model('Crosspromos', 'model');
    
    $id = $params['game'];

    $data['game_id'] = $id;
    
    $this->load->model('Games', 'games');
    $this->load->model('Gameplatforms', 'gp');
    $this->load->model('Platforms', 'platforms');
    $gp = $this->gp->find($id);
    
    $data['items'] = array();
    
    $data['list_id'] = false;
    $data['lists'] = false;
    
    $data['game'] = $this->games->find($gp->game_id);
    
    $data['game_platform'] = $gp;
    
    if ($gp) {
    
      $this->load->model('Crosspromolists', 'lists');
      
      $lists = $this->lists->fetchForGame($id);
      
      $data['lists'] = $lists;
      
      $list_id = false;
      if ($lists && $lists[0] && !isset($params['list'])) {
        $list_id = $lists[0]->id;
      } else {
        if (isset($params['list'])) {
          $list_id = $params['list'];
        }
      }
      
      unset($data['params']['list']);
      
      $data['list_id'] = $list_id;
      
      $data['is_free'] = $this->lists->isFree($list_id);
      
      if ($this->lists->find($list_id)) {
        
        $data['items'] = $this->model->fetchByGame($id, $list_id, $params);
      }
      
    }
    
    $this->template->build('promo/game', $data);
  }
  
  public function console()
  {
    $data = array();

    $this->load->model('Gameplatforms', 'model');
    
    $token = false;
    
    $data['response'] = false;
    
    
    if ($_POST) {
      
      $responseType = $_POST['response_type'];
      //unset($_POST['response_type']);
      $res = $this->curl->simple_post(base_url().'promo/add_device/xml', $_POST); 
      
      $data['response'] = $res;
      //dump($this->curl->error_string);
      //dump(base_url().'promo/add_device/'.$responseType); die;
    }
    
    //$data['games'] = $this->model->toAssocArray('id', 'game_name+platform_name', $this->model->fetchAllWithGameAndPlatform());  
    
    $this->load->model('Games', 'games');
    $data['games'] = $this->games->fetchAll();
    
    $this->template->build('promo/add_device', $data);
  }
  
  public function add_device() 
  {

    if (isset($_GET['device_id'])) {
      $_POST = $_GET;
      $_POST['game_name'] = urldecode($_POST['game_name']);
    }
    
    //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'before validation:' . json_encode($_POST) . "\r\n", FILE_APPEND);
    $this->form_validation->set_error_delimiters('', '');
    
    //dump($_POST); die;
    $this->form_validation->set_rules('device_id', 'device_id', 'trim|required');
    $this->form_validation->set_rules('game_name', 'game id', 'trim|required');
    $this->form_validation->set_rules('platform_name', 'platform_name', 'trim|required');
    $this->form_validation->set_rules('platform_type', 'platform_type', 'trim|required');
    $this->form_validation->set_rules('os_version', 'os version', 'trim|required');
    $this->form_validation->set_rules('game_version', 'game version', 'trim|required');
    
    $response = array();
    if ($this->form_validation->run()) {
      //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'after validation:' . json_encode($_POST) . "\r\n", FILE_APPEND);
      
      $this->load->model('Users', 'user');
      $this->load->model('Usergames', 'usergame');
      $this->load->model('Gameplatforms', 'gameplatform');
      $this->load->model('Games', 'game');
      $this->load->model('Platforms', 'platform');
            
      $game = $this->game->findByName($_POST['game_name']);
      $platform = $this->platform->findByName($_POST['platform_name'], $_POST['platform_type']);
      
      $game = $game ? $game->id : $game;
      $platform = $platform ? $platform->id : $platform;


      /** 
       * megkeressuk a jatek id es a platform alapjan, hogy miylen game_platform_id tartozik a kapott parameterkhez
       *
       * @author Dobi Attila
       */
      $_POST['game_id'] = $this->gameplatform->findByGameAndPlatform($game, $platform);
      
      $userid = false;
      if ($_POST['game_id']) {
        
        $_POST['game_id'] = $_POST['game_id']->id;
        //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'game_platform_id:' . json_encode($_POST) . "\r\n", FILE_APPEND);
        $insert = false;
        /**
         * ellenorizni, hogy az adott device_id szerepelt e mar nalunk
         *
         * @author Dobi Attila
         */
        if (! ($device = $this->user->findBy('device_id', $_POST['device_id']))) {
          
          $user = array('device_id'=>$_POST['device_id'], 'os_version'=>$_POST['os_version'], 'os_type'=>$_POST['platform_name'], 'device_type'=>$_POST['platform_type'], 'created'=>date('Y-m-d H:i:s', time()));
          $userid = $this->user->insert($user);
          $insert = true;
        } else {
          $userid = $this->user->find($device->id)->id;
        }
        
        /**
         * megnezni, hogy a jatek szerepelt e mar
         * - ha igen, es kulonboznek a verziok, akkor frissiteni a verziot
         * - ha igen, es azonosak a verziok, akkor nem csinalnunk semmit 
         * - ha nem akkor felvesszuk
         *
         * @author Dobi Attila
         */
         if (! ($usergame = $this->usergame->findGameByDevice($game, $userid))) {
           $this->usergame->insert(array('user_id'=>$userid, 'game_id'=>$game, 'game_version'=>$_POST['game_version']));
         } else {
           if (!$insert) {
             if ($usergame->game_version < $_POST['game_version']) {
               $this->usergame->update(array('game_version'=>$_POST['game_version']), $usergame->id);
             }
           }
         }
        
        $response['success'] = array('game'=>$_POST['game_id']);
      } else {
        $response['error'] = 'Invalid game id';
      }
    } else {
      $response['error'] = validation_errors();
    }
    //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'response:' . json_encode($response) . "\r\n", FILE_APPEND);
    
    $responseType = "json";
    
    if ($this->uri->segment(3)) {
      $responseType = $this->uri->segment(3);
    }
    
    if (isset($_POST['response_type'])) {
      $responseType = $_POST['response_type'];
    }
    
    //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'response_type:' . json_encode($responseType) . "\r\n", FILE_APPEND);
    
    if ($responseType === 'json') {
      
      $result = json_encode($response);
    }
    
    if ($responseType === 'xml') {
      
      if (isset($response['success'])) {
        $result = '<success><game>'.$response['success']['game'].'</game></success>';
      }
      
      if (isset($response['error'])) {
        $result = '<error>'.htmlspecialchars($response['error']).'</error>';
      }
    }

    echo $result;

    //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'result:' . json_encode($result) . "\r\n", FILE_APPEND);

    //file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', "----------------------------------------------------------------------------------------------------------------". "\r\n", FILE_APPEND);
    die;
    
  }
  
  public function get_token()
  {
    $response['name'] = $this->security->get_csrf_token_name();
    $response['value'] = $this->security->get_csrf_hash();
    //$response['value'] = $_COOKIE['invictus_crosspromo_csrf_coockie'];
    
    echo json_encode($response); die;
  }
}