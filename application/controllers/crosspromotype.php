<?php 

if (! defined('BASEPATH')) exit('No direct script access');

//require_once 'MY_Controller.php';

class Crosspromotype extends MY_Controller 
{
    public function index() 
    {
        $data = array();
        
        $this->load->model('Crosspromotypes', 'model');
        
        $data['items'] = $this->model->fetchAll();
        
        $this->template->build('crosspromotype/index', $data);
    }
    
    public function edit() 
    {
        $data = array();
        
        $id = $this->uri->segment(3);
        
        $this->load->model('Crosspromotypes', 'model');
        
        $item = false;
        if ($id) {
            $item = $this->model->find((int)$id);
        }
        $data['item'] = $item;
        
        $this->form_validation->set_rules("name", "Name", "trim|required");
		
        
        if ($this->form_validation->run()) {
            if ($this->upload->do_upload('image')) {
                
                if ($id) {
                    
                    $this->_deleteImage($id);
                }
                
                $_POST['image'] = $this->upload->file_name;
            } 
            
            //dump($_POST); dump($id); die;       
            if (is_numeric($id)) {
                $this->model->update($_POST, $id);
            } else {
                $this->model->insert($_POST);
            }
            
            $this->session->set_userdata('selected-sidebar-tab', 'types');
            
            redirect('crosspromo#'.$this->session->userdata('selected_game'));
        }
        $this->template->build('crosspromotype/edit', $data);
    }
    
    public function delete()
    {
        $id = $this->uri->segment(3);
        
        if ($id) {
            $this->load->model('Crosspromotypes', 'model');
            
            $this->_deleteImage($id, true);
        }
        
        //redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function get()
    {
      $this->load->model('Crosspromotypes', 'model');
      $response['item'] = $this->model->find($this->uri->segment(3));
      $response['save_url'] = base_url().'crosspromotype/edit/'.$this->uri->segment(3);
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
        
        die;
    }
    
    private function _deleteImage($id, $withRecord = false) 
    {
        $this->load->model('Crosspromotypes', 'model');
        
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