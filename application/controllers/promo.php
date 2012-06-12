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
  
  public function game() 
  {
    $data = array();
    $this->load->model('Crosspromos', 'model');
    
    $id = $this->uri->segment(3);

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
      
      $lists = $this->lists->fetchRows(array('where'=>array('is_active'=>1),'order'=>array('by'=>'order', 'dest'=>'asc')));
      
      //$return = array();
      //foreach ($types as $value) {
      //  $return[] = array('list'=>$value, 'games'=>$this->model->fetchByGame($this->uri->segment(3), $value->id));
      //}
      
      //$data['result'] = $return;
      
      $data['lists'] = $lists;

      if ($lists && $lists[0] && !$this->uri->segment(4)) {
        $list_id = $lists[0]->id;
      } else {
        if ($this->uri->segment(4)) {
          $list_id = $this->uri->segment(4);
        }
      }
      
      $data['list_id'] = $list_id;
      
      if ($this->lists->find($list_id)) {
        
        $data['items'] = $this->model->fetchByGame($id, $list_id);
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
      
      if ($this->gameplatform->find($_POST['game_id'])) {
        $user = array('device_id'=>$_POST['device_id'], 'os_version'=>$_POST['os_version']);
        $userid = $this->user->insert($user);
        
        $usergame = array('user_id'=>$userid, 'game_id'=>$_POST['game_id'], 'game_version'=>$_POST['game_version']);
        $this->usergame->insert($usergame);
        
        $response['success'] = 'Saved';
      } else {
        $response['error'] = 'Invalid game id';
      }
    } else {
      $response['error'] = validation_errors();
    }
    
    redirect($_SERVER['HTTP_REFERER']);
    
    echo json_encode($response);
    
    die;
    
  }
}