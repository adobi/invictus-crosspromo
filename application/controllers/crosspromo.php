<?php 

if (! defined('BASEPATH')) exit('No direct script access');

//require_once 'MY_Controller.php';

class Crosspromo extends MY_Controller 
{
    public function index() 
    {
      $data = array();
      
      //$this->load->model('Games', 'model');
      //$games = $this->model->fetchWithCrosspromo();
      
      $this->load->model('Gameplatforms', 'model');
      
      $games = $this->model->fetchAllWithGameAndPlatform();
      
      $data['games_select'] = $this->model->toAssocArray('id', 'game_name+platform_name', $games);
      //$data['games'] = $games;
      
      $this->load->model('Crosspromotypes', 'types');
      
      $data['types'] = $this->types->fetchAll();
      
      $this->template->build('crosspromo/index', $data);
    }
    
    public function edit() 
    {
      $id = $this->uri->segment(3);
      
      $this->form_validation->set_rules('promo_game_id', 'Promo game', 'trim|required');
      
      $id = false;
      if ($this->form_validation->run()) {
        
        $this->load->model("Crosspromos", 'model');

        
        //$this->model->setupAnalytics($this->session->userdata('selected_game'), $_POST['promo_game_id'], $_POST);
        
        if ($id && $id !== "0") {
          
          $this->model->update($_POST, $id);
          
        } else {
          
          $_POST['base_game_id'] = $this->session->userdata('selected_game');
          
          $_POST['order'] = 1000;
          
          $id = $this->model->insert($_POST);
        }
        
        $this->model->setupAnalytics($id);
        
        echo $id;
      }
      
      die;
    }
    
    public function for_game()
    {
      $data = array();
      
      $this->load->model('Crosspromos', 'model');
      
      $this->session->set_userdata('selected_game', $this->uri->segment(3)); 
      
      $this->load->model('Games', 'games');
      $this->load->model('Gameplatforms', 'gp');
      $this->load->model('Platforms', 'platforms');
      $gp = $this->gp->find($this->uri->segment(3));
      
      if (!$gp) die;
      
      $data['game'] = $this->games->find($gp->game_id);
      $data['platform'] = $this->platforms->find($gp->platform_id);
      
      $this->load->model('Crosspromolists', 'lists');
      
      $lists = $this->lists->fetchRows(array('where'=>array('game_id'=>$gp->id), 'order'=>array('by'=>'order', 'dest'=>'asc')));
      
      $return = array();
      foreach ($lists as $value) {
        
        $return[] = array('list'=>$value, 'games'=>$this->model->fetchByGame($this->uri->segment(3), $value->id));
      }
      
      $data['result'] = $return;
      
      //$data['games'] = $this->model->fetchByGame($this->uri->segment(3));
      //dump($data['result']); die;
      
      echo json_encode($data); die;
      
      $this->template->build('crosspromo/for_game', $data);
    }
    
    public function update_order()
    {
        if ($_POST && isset($_POST['order'])) {
            
            $this->load->model('Crosspromos', 'model');
            
            foreach ($_POST['order'] as $order => $id) {
              if ($id)
                $this->model->update(array('order'=>$order), $id);
            }
        }
        
        die;
    } 
    
    public function delete()
    {
        $id = $this->uri->segment(3);
        
        if ($id) {
            $this->load->model('Crosspromos', 'model');
            
            $this->model->delete($id);
        }
        
        //redirect($_SERVER['HTTP_REFERER']);
        die;
    } 
    
    public function generate_analytics()
    {
      $this->load->model('Crosspromos', 'model');
      
      $promos = $this->model->fetchAll();
      
      if ($promos) {
        
        foreach ($promos as $item) {
          $data = array();
          
          $data = $this->model->setupAnalytics($item->base_game_id, $item->promo_game_id, $data);
          
          $this->model->update($data, $item->id);
        }
      }
      redirect($_SERVER['HTTP_REFERER']);
    }    
    
    public function load_all_games()
    {
      $data = array();
      
      $this->load->model('Games', 'model');
      $games = $this->model->fetchWithCrosspromo();
      
      $data['games'] = $games;
      
      $this->template->build('crosspromo/load_all_games', $data);      
    }
    
    public function empty_promo_game()
    {
      $id = $this->uri->segment(3);
      
      if ($id) {
        $this->load->model('Crosspromos', 'model');
        
        $this->model->update(array('promo_game_id'=>null), $id);
      }
    }
    
    public function save_description_to_item()
    {
      if ($_POST) {
        $id = $this->uri->segment(3);
        
        if ($id) {
          $this->load->model('Crosspromos', 'model');
          
          $this->model->update($_POST, $id);
          
          if (isset($_POST['promo_price']) && $_POST['promo_price']) {
            
            $item = $this->model->find($id);
            
            if (!$item) return false;
            
            $this->model->update(array('promo_price'=>$_POST['promo_price']), array('promo_game_id'=>$item->promo_game_id));
          }
        }
      }
      
      die;
    }
    
    /**
     * edit crosspromo list item
     *
     * @return void
     * @author Dobi Attila
     */
    public function get()
    {
      $this->load->model('Crosspromos', 'model');
      $this->load->model('Crosspromotypes', 'types');

      $response['item'] = $this->model->find($this->uri->segment(3));
      
      if ($response['item']) {
        
        $this->load->model('Gameplatforms', 'gp');
        $this->load->model('Games', 'game');
        
        $gp = $this->gp->find($response['item']->promo_game_id);
        $game = $this->game->find($gp->game_id);
        
        $response['item']->description = (
          $response['item']->description ? 
          $response['item']->description : 
          $game->crosspromo_description);
        
      }
      //$response['types'] = $this->types->toAssocArray('id', 'name', $this->types->fetchAll());
      $response['types'] = $this->types->fetchAll();
      echo json_encode($response);
      die;
      
      $this->template->build('crosspromo/edit', $response);
    } 
    
    public function switch_value()
    {
      if ($_POST) {
        $id = $this->uri->segment(3);
        
        if ($id) {
          $this->load->model('Gameplatforms', 'model');
          
          $this->model->update($_POST, $id);
        }
      }
      
      die;
    } 
    
    public function add_type() 
    {
      $this->load->model('Crosspromos', 'model');
      
      if ($this->uri->segment(3) && $_POST) {
        $this->model->update($_POST, $this->uri->segment(3));

        /**
         * ha a kivalasztott tipus "NEW" akkor beallitjuk az is_new flag-et, egyebkent 0
         *
         * @author Dobi Attila
         */
        $this->load->model('Crosspromotypes', 'type');
        $type = $this->type->find($_POST['type_id']);
        $promo = $this->model->find($this->uri->segment(3));
        $this->load->model('Gameplatforms', 'gp');
        
        if (strpos(strtolower($type->name), 'new') !== false) {
          $this->gp->update(array('is_new'=>1), $promo->promo_game_id);
        } else {
          $this->gp->update(array('is_new'=>0), $promo->promo_game_id);
        }

      }
      
      die;
    }
    
    public function copy_list()
    {
      //$this->form_validation->set_rules('target_games[]', 'Target games', 'required');
      
      $response = array();
      //dump($_POST);
      //if ($this->form_validation->run()) {
      if (isset($_POST) && isset($_POST['target_games'])) {
        
        $list = $this->uri->segment(3);
        
        $this->load->model('Crosspromolists', 'lists');
        
        if ($this->lists->copyList($list, $_POST['target_games'])) {
          $response['success'] = 1;
        } else {
          $response['error'] = 'Something went wrong, try again later';
        }
        
      } else {
        
        if (isset($_POST))
          $response['error'] = 'Select some games';
      }
      
      echo json_encode($response);
      
      die;
    }
    
    public function delete_user()
    {
      $this->load->model('Users', 'model');
      
      $this->model->delete($this->uri->segment(3));
      
      die;
    }
    
    public function delete_usergame()
    {
      $this->load->model('Usergames', 'model');
      
      $this->model->delete($this->uri->segment(3));
      
      die;
    }
    
}