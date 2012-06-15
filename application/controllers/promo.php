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
    
    //dump($this->uri->uri_to_assoc(3)); die;
    
    $data = array();
    $params = $this->uri->uri_to_assoc(3);
    
    $data['params'] = $params;
    

    $this->load->model('Crosspromos', 'model');
    
    //$id = $this->uri->segment(3);
    $id = $params['game'];

    $data['game_id'] = $id;
    
    $this->load->model('Games', 'games');
    $this->load->model('Gameplatforms', 'gp');
    $this->load->model('Platforms', 'platforms');
    $gp = $this->gp->find($id);
    
    $data['items'] = array();
    
    $data['list_id'] = false;
    $data['lists'] = false;
    if ($gp) {
    
      $this->load->model('Crosspromolists', 'lists');
      
      $lists = $this->lists->fetchForGame($id);
      
      //$return = array();
      //foreach ($types as $value) {
      //  $return[] = array('list'=>$value, 'games'=>$this->model->fetchByGame($this->uri->segment(3), $value->id));
      //}
      
      //$data['result'] = $return;
      
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
    //dump($list_id);
    //dump($data['items']); die;
    
    $this->template->build('promo/game', $data);
  }
  
  public function add_device_ui()
  {
    $data = array();

    $this->load->model('Gameplatforms', 'model');
    
    $token = false;
    
    if ($this->uri->segment(3) === 'get_token') {
      
      $response = file_get_contents(base_url().'promo/get_token');
      
      $token = json_decode($response);
    }
    
    if ($_POST) {
      $res = $this->curl->simple_post(base_url().'promo/add_device', $_POST);      
    }
    
    $data['token'] = $token;
    
    $data['games'] = $this->model->toAssocArray('id', 'game_name+platform_name', $this->model->fetchAllWithGameAndPlatform());  
    
    $this->template->build('promo/add_device', $data);
  }
  
  public function add_device() 
  {
    $this->form_validation->set_rules('device_id', 'user id', 'trim|required');
    $this->form_validation->set_rules('game_id', 'game id', 'trim|required');
    $this->form_validation->set_rules('os_version', 'os version', 'trim|required');
    $this->form_validation->set_rules('game_version', 'game version', 'trim|required');
    
    $_POST[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
    //$response['token_value'] = $this->security->get_csrf_hash();
    
    $response = array();
    if ($this->form_validation->run()) {
      
      $this->load->model('Users', 'user');
      $this->load->model('Usergames', 'usergame');
      $this->load->model('Gameplatforms', 'gameplatform');
      
      $game = $this->game->findByName($_POST['game_name']);
      $platform = $this->platform->findByName($_POST['platform_name']);
      
      if ($this->gameplatform->find($_POST['game_id'])) {
        
        /**
         * ellenorizni, hogy az adott device_id szerepelt e mar nelunk
         *
         * @author Dobi Attila
         */
        if (!$this->user->findByDeviceId($_POST['device_id'])) {
          
          $user = array('device_id'=>$_POST['device_id'], 'os_version'=>$_POST['os_version'], 'os_type'=>$_POST['os_type']);
          $userid = $this->user->insert($user);
        }
        
        /**
         * megnezni, hogy a jatek szerepelt e mar
         * - ha igen, es kulonboznek a verziok, akkor frissiteni a verziot
         * - ha igen, es azonosak a verziok, akkor nem csinalnunk semmit 
         * - ha nem akkor felvesszuk
         *
         * @author Dobi Attila
         */
        $usergame = array('user_id'=>$userid, 'game_id'=>$_POST['game_id'], 'game_version'=>$_POST['game_version']);
        $this->usergame->insert($usergame);
        
        /**
         * megkeressuk a jatek id es a platform alapjan, hogy miylen game_platform_id tartozik a kapott parameterkhez
         *
         * @author Dobi Attila
         */
        
        $response['success'] = '';
      } else {
        $response['error'] = 'Invalid game id';
      }
    } else {
      $response['error'] = validation_errors();
    }
    
    //redirect($_SERVER['HTTP_REFERER']);
    
    echo json_encode($response);
    
    die;
    
  }
  
  public function get_token()
  {
    $response['name'] = $this->security->get_csrf_token_name();
    $response['value'] = $this->security->get_csrf_hash();
    
    echo json_encode($response); die;
  }
}