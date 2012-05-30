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
        
            if ($id) {
                $this->model->update($_POST, $id);
            } else {
                $id = $this->model->insert($_POST);
            }
            
            $response['list'] = array('id'=>$id, 'name'=>$_POST['name']);
            //redirect($_SERVER['HTTP_REFERER']);
        }
        
        echo json_encode($response); die;
        
        $this->template->build('crosspromolist/edit', $data);
    }
    
    public function delete()
    {
        $id = $this->uri->segment(3);
        
        if ($id) {
            $this->load->model('Crosspromolists', 'model');
            
            $this->model->delete($id);
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
}