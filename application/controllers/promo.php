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
    //dump($data['games']); die;
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
    $data['current_list'] = false;
    
    $data['game'] = $this->games->find($gp->game_id);
    
    $data['game_platform'] = $gp;
    
    if (isset($params['thanks'])) {
      
      $this->load->model('Users', 'user');
      
      $user = $this->user->findBy('device_id', $params['device']);
      
      if ($user) {
        
        $this->load->model('Clicks', 'click');
        
        if ($this->click->isGameClickedBy($gp->id, $user->id)) {
          /*
            TODO record the order, pass the parameters for the analytics
          */

          $this->load->model('Users', 'user');
          
          $user = $this->user->findBy('device_id', $params['device']);      
          
          if (!$user) return false;
                    
          $this->load->model('Orders', 'order');
          
          $order = array(
            'created'=>date('Y-m-d H:i:s', time()),
            'game_id'=>$params['game'],
            'user_id'=>$user->id,
            'quantity'=>1
          );
          
          $orderId = $this->order->insert($order);
          
          $this->load->model('Orders', 'order');
          $data['loyalty'] = $this->order->getLoyalty($user->id);
          
          $this->load->model('Categories', 'category');
          
          $category = $this->category->find($data['game']->category_id);
          
          $this->load->model('Clicks', 'click');
          
          $data['transaction'] = array(
            "order_id"=>$orderId,
            "sku"=>$params['game'],
            "name"=>$data['game']->name,
            "category"=>$category ? $category->name : '',
            "price"=>$this->gp->getActualPrice($gp->id), // crosspromos ar ha van neki olyan
            "quantity"=>1,
            'store_name'=>$this->click->getTypeFromLatestClick($gp->id, $user->id), // item type a click utan
            'tax'=>'',
            'shipping'=>'',
            'city'=>'Debrecen',
            'state'=>'Hajdú-Bihar',
            'country'=>'HUN',
            'created'=>date('Y-m-d H:i:s', time())
          );
          
          $this->load->model('Transactions', 'trans');
          
          $this->trans->insert($data['transaction']);
        }
      }
      
      //$this->template->build('promo/thanks', $data);
    }
      
    if ($gp) {
    
      $this->load->model('Crosspromolists', 'lists');
      
      $lists = $this->lists->fetchForGame($id);
      
      $data['lists'] = $lists;
      
      $list_id = false;
      if ($lists && $lists[0] && !isset($params['list'])) {
        $list_id = $lists[0]->id;
        $data['current_list'] = $lists[0];
      } else {
        if (isset($params['list'])) {
          $list_id = $params['list'];
          $data['current_list'] = $this->lists->find($params['list']);
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
  
  /**
   * keszulek elmetese
   *
   * @param device_id string md5 hash
   * @param game_name string
   * @param platform_name ios|android
   * @param plartform_type phone|tablet
   * @param os_version 
   * @param game_version
   *
   * @return json|xml game_platfor_id es van e lista az adott jatekhoz
   * @author Dobi Attila
   */
  public function add_device() 
  {
    $debug = false;

    if ($debug)
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', "----------------------------------------------------------------------------------------------------------------". "\r\n", FILE_APPEND);
      
    if (isset($_GET['device_id'])) {
      $_POST = $_GET;
      $_POST['game_name'] = urldecode($_POST['game_name']);
    }
    
    if ($debug)
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'before validation:' . json_encode($_POST) . "\r\n", FILE_APPEND);
      
    $this->form_validation->set_error_delimiters('', '');
    
    //dump($_POST); die;
    $this->form_validation->set_rules('device_id', 'device_id', 'trim|required');
    $this->form_validation->set_rules('game_name', 'game name', 'trim|required');
    $this->form_validation->set_rules('platform_name', 'platform_name', 'trim|required');
    $this->form_validation->set_rules('platform_type', 'platform_type', 'trim|required');
    $this->form_validation->set_rules('os_version', 'os version', 'trim|required');
    $this->form_validation->set_rules('game_version', 'game version', 'trim|required');
    
    $response = array();
    if ($this->form_validation->run()) {
      if ($debug)
        file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'after validation:' . json_encode($_POST) . "\r\n", FILE_APPEND);
      
      $this->load->model('Users', 'user');
      $this->load->model('Usergames', 'usergame');
      $this->load->model('Gameplatforms', 'gameplatform');
      $this->load->model('Games', 'game');
      $this->load->model('Platforms', 'platform');
      
      $game = $this->game->findByName($_POST['game_name']);
      if ($debug)      
        file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'game:' . json_encode($game) . "\r\n", FILE_APPEND);
        
      $platform = $this->platform->findByName($_POST['platform_name'], $_POST['platform_type']);
      if ($debug)      
        file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'platform:' . json_encode($platform) . "\r\n", FILE_APPEND);
      
      $game = $game ? $game->id : $game;
      $platform = $platform ? $platform->id : $platform;

      /** 
       * megkeressuk a jatek id es a platform alapjan, hogy miylen game_platform_id tartozik a kapott parameterkhez
       *
       * @author Dobi Attila
       */
      $_POST['game_id'] = $this->gameplatform->findByGameAndPlatform($game, $platform);
      
      
      
      if ($debug)      
        file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'game_id:' . json_encode($_POST['game_id']) . "\r\n", FILE_APPEND);

      $userid = false;
      if ($_POST['game_id']) {
        
        $_POST['game_id'] = $_POST['game_id']->id;
        if ($debug)
          file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'game_platform_id:' . json_encode($_POST) . "\r\n", FILE_APPEND);
          
        $insert = false;
        /**
         * ellenorizni, hogy az adott device_id szerepelt e mar nalunk
         *
         * @author Dobi Attila
         */
        $device =  $this->user->findBy('device_id', $_POST['device_id']);
        if ($debug)
          file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'device:' . json_encode($device) . "\r\n", FILE_APPEND);
        
        if (! ($device)) {
          
          $user = array('device_id'=>$_POST['device_id'], 'os_version'=>$_POST['os_version'], 'os_type'=>$_POST['platform_name'], 'device_type'=>$_POST['platform_type'], 'created'=>date('Y-m-d H:i:s', time()));
          $userid = $this->user->insert($user);
          if ($debug)
            file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'userid (insert):' . json_encode($userid) . "\r\n", FILE_APPEND);
            
          $insert = true;
        } else {
          $userid = $this->user->find($device->id)->id;
          if ($debug)
            file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'userid (find):' . json_encode($userid) . "\r\n", FILE_APPEND);
            
        }
        
        //echo $_POST['game_id'];
        /**
         * megnezni, hogy a jatek szerepelt e mar
         * - ha igen, es kulonboznek a verziok, akkor frissiteni a verziot
         * - ha igen, es azonosak a verziok, akkor nem csinalnunk semmit 
         * - ha nem akkor felvesszuk
         *
         * @author Dobi Attila
         */
        if ($debug)
          file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'usergame (params):' . json_encode(array('game'=>$game, 'userid'=>$userid)) . "\r\n", FILE_APPEND); 
        $usergame = $this->usergame->findGameByDevice($game, $userid);
        if ($debug)
          file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'usergame (find):' . json_encode($usergame) . "\r\n", FILE_APPEND);         
         if (! ($usergame)) {
           
           /**
            * fekvo nezet az alapertelmezett
            *
            * @author Dobi Attila
            */
           /*  
           if ($_POST['width'] < $_POST['height']) {
             
             $width = $_POST['width'];
             
             $_POST['width'] = $_POST['height'];
             $_POST['height'] = $width;
             unset($width);
           }
           */
           $insertData = array('user_id'=>intval($userid), 'game_id'=>$game, 'game_version'=>$_POST['game_version'], 'width'=>$_POST['width'], 'height'=>$_POST['height'], 'opengl'=>$_POST['opengl'], 'device'=>isset($_POST['device']) ? $_POST['device'] : '');
           if ($debug)
              file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'usergame (insert data):' . json_encode($insertData) . "\r\n", FILE_APPEND);
           $insertedUserGame = $this->usergame->insert($insertData);
           
           if ($debug)
              file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'usergame (insert):' . json_encode($insertedUserGame) . "\r\n", FILE_APPEND);
              
         } else {
           if (!$insert) {
             if ($usergame->game_version < $_POST['game_version']) {
               $updatedUserGame = $this->usergame->update(array('game_version'=>$_POST['game_version']), $usergame->id);
               
                if ($debug)
                  file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'usergame (update):' . json_encode($updatedUserGame) . "\r\n", FILE_APPEND);
                          
             }
           }
         }
        
        $response['success'] = array('game'=>$_POST['game_id']);
        
        $this->load->model('Crosspromolists', 'lists');
        
        $response['success']['has_list'] = $this->lists->hasGameList($_POST['game_id']);
        
      } else {
        $response['error'] = 'Invalid game id';
      }
    } else {
      $response['error'] = validation_errors();
    }
    if ($debug)
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'response:' . json_encode($response) . "\r\n", FILE_APPEND);
    
    $responseType = "json";
    
    if ($this->uri->segment(3)) {
      $responseType = $this->uri->segment(3);
    }
    
    if (isset($_POST['response_type'])) {
      $responseType = $_POST['response_type'];
    }
    
    if ($debug)
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'response_type:' . json_encode($responseType) . "\r\n", FILE_APPEND);
    
    if ($responseType === 'json') {
      
      $result = json_encode($response);
    }
    
    if ($responseType === 'xml') {
      
      header ("Content-Type:text/xml");  
      
      if (isset($response['success'])) {
        $result = '<success><game>'.$response['success']['game'].'</game>';
        
        $result .= '<has_list>'.$response['success']['has_list'].'</has_list>';
        
        $result .= '</success>';
      }
      
      if (isset($response['error'])) {
        $result = '<error>'.htmlspecialchars($response['error']).'</error>';
      }
    }
    echo $result;
    
    if ($debug)
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', 'result:' . json_encode($result) . "\r\n", FILE_APPEND);

    if ($debug)
      file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']).'/debug.txt', "----------------------------------------------------------------------------------------------------------------". "\r\n", FILE_APPEND);
    
    die;
    
  }
  
  public function click() 
  {
    $this->form_validation->set_rules('game_id', 'game id', 'trim|required');
    $this->form_validation->set_rules('user_id', 'user id', 'trim|required');
    
    if ($this->form_validation->run()) {
      $_POST['created'] = date('Y-m-d H:i:s', time());
      

      $this->load->model('Users', 'user');
      
      $user = $this->user->findBy('device_id', $_POST['user_id']);      
      
      if (!$user) return false;
      
      $_POST['user_id'] = $user->id;
      
      $this->load->model('Clicks', 'click');
      
      $this->click->insert($_POST);
    }
    
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