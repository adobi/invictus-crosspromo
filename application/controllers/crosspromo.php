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
      
      $this->template->build('crosspromo/index', $data);
    }
    
    public function edit() 
    {
      $id = $this->uri->segment(3);
      
      $this->form_validation->set_rules('promo_game_id', 'Promo game', 'trim|required');
      
      if ($this->form_validation->run()) {
        
        $this->load->model("Crosspromos", 'model');
        
        /*
          TODO generate analytics
        */
        
        $this->model->setupAnalytics($this->session->userdata('selected_game'), $_POST['promo_game_id'], $_POST);
        
        if ($id && $id !== "0") {
          
          $this->model->update($_POST, $id);
          
        } else {
          
          $_POST['base_game_id'] = $this->session->userdata('selected_game');
          
          $_POST['order'] = 1000;
          
          echo $this->model->insert($_POST);
        }
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
      
      $this->load->model('Crosspromolists', 'types');
      
      $types = $this->types->fetchAll(array('order'=>array('by'=>'order', 'dest'=>'asc')));
      
      $return = array();
      foreach ($types as $value) {
        $return[] = array('list'=>$value, 'games'=>$this->model->fetchByGame($this->uri->segment(3), $value->id));
      }
      
      $data['result'] = $return;
      
      //$data['games'] = $this->model->fetchByGame($this->uri->segment(3));
      //dump($data['games']); die;
      
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
}