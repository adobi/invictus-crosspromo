<?php 

if (! defined('BASEPATH')) exit('No direct script access');

//require_once 'MY_Controller.php';

class Crosspromolist extends MY_Controller 
{
    public function index() 
    {
        $data = array();
        
        $this->load->model('Crosspromolists', 'model');
        
        $data['items'] = $this->model->fetchAll();
        
        $this->template->build('crosspromolist/index', $data);
    }
    
    public function edit() 
    {
        $data = array();
        
        $id = $this->uri->segment(3);
        
        $this->load->model('Crosspromolists', 'model');
        
        $item = false;
        if ($id) {
            $item = $this->model->find((int)$id);
        }
        $data['item'] = $item;
        
        $this->form_validation->set_rules("name", "Name", "trim|required");

    		$response = array();
    		
        if ($this->form_validation->run()) {

            if ($this->upload->do_upload('image')) {
                
                if ($id) {
                    
                    $this->_deleteImage($id);
                }
                
                $_POST['image'] = $this->upload->file_name;
            }

            if ($id) {
                $this->model->update($_POST, $id);
                
                $this->load->model('Crosspromos', 'promo');
                
                $items = $this->promo->fetchBy('list_id', $id);
                
                if ($items) {
                  foreach ($items as $item) {
                    $this->promo->setupAnalytics($item->id);
                  }
                }
                
            } else {
                $id = $this->model->insert($_POST);
            }
            
            $response['list'] = array('id'=>$id, 'name'=>$_POST['name']);
            redirect('crosspromo#'.$this->session->userdata('selected_game'));
        }
        
        //echo json_encode($response); die;
        
        $this->template->build('crosspromolist/edit', $data);
    }
    
    public function delete()
    {
        $id = $this->uri->segment(3);
        
        if ($id) {
            $this->load->model('Crosspromolists', 'model');
            
            $this->_deleteImage($id, true);
        }
        die;
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function update_order()
    {
        if ($_POST && isset($_POST['order'])) {
            
            $this->load->model('Crosspromolists', 'model');
            
            foreach ($_POST['order'] as $order => $id) {
              if ($id)
                $this->model->update(array('order'=>$order), $id);
            }
        }
        
        die;
    }   
    
    public function switch_value()
    {
      if ($_POST) {
        $id = $this->uri->segment(3);
        
        if ($id) {
          $this->load->model('Crosspromolists', 'model');
          
          $this->model->update($_POST, $id);
        }
      }
      
      die;
    } 
    public function get()
    {
      $this->load->model('Crosspromolists', 'model');
      $response['item'] = $this->model->find($this->uri->segment(3));
      $response['save_url'] = base_url().'crosspromolist/edit/'.$this->uri->segment(3);
      $response['token_name'] = $this->security->get_csrf_token_name();
      $response['token_value'] = $this->security->get_csrf_hash();
      $response['selected_game'] = $this->session->userdata('selected_game');
      echo json_encode($response);
      die;
    } 

    public function delete_image() 
    {
        $id = $this->uri->segment(3);
        
        if ($id) {
            
            $this->_deleteImage($id);
            
            $this->session->set_flashdata('message', 'Deleted');
        }
        
        //echo display_success('Deleted');
        
        die;
        
        //redirect($_SERVER['HTTP_REFERER']);
    }
    
    private function _deleteImage($id, $withRecord = false) 
    {
        $this->load->model('Crosspromolists', 'model');
        
        $item = $this->model->find($id);
        
        if ($item && $item->image) {
            $this->load->config('upload');
            
            @unlink($this->config->item('upload_path') . $item->image);
        }
        
        if (!$withRecord) {
            
            $this->model->update(array('image'=>null), $id);
        }
        
        return $withRecord ? $this->model->delete($id) : true;
    }              
}