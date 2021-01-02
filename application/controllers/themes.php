<?php defined('BASEPATH') OR exit ('No direct script are allowed');
  class themes extends CI_Controller
  {
    
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Themes_model', 'themes');
    }
    
    public function index () {
      $result = $this->Constant_model->api_format();
      $post = $this->input->post();
      $data = $this->themes->getData($post);
      if ($data != null) {
        $result = $this->Constant_model->api_format (1, $data, 'Data loaded successfuly');
      } else {
        $result = $this->Constant_model->api_format (0, $data, 'There is no data loaded');
      }
      echo json_encode($result);
    }

    public function insert () {
      $result = $this->Constant_model->api_format();
      
      $post = $this->input->post();
      $this->form_validation->set_rules('name', 'Name', 'trim|required');
      $this->form_validation->set_rules('description', 'Description', 'trim|required');
      if ($this->form_validation->run() == false) {
        $result = $this->Constant_model->api_format(0, $this->form_validation->error_array(), 'Failed to insert data');
      } else {
        $themes_id = $this->Constant_model->generate_id('themes', 'THM');
        $created_date = new DateTime();
        $data = array (
          'theme_id' => $themes_id,
          'name' => $post['name'],
          'description' => $post['description'],
          'created_at' => $created_date->format("Y-m-d H:i:s"),
          'updated_at' => null,
          'deleted_at' => null
        );
        $response_code = ($this->themes->insert($data))? 1 : 0;
        $result = $this->Constant_model->api_format($response_code, null, 'Data inserted successfuly');
      }
      echo json_encode($result);
      
    }
    public function update ($id) {
      $result = $this->Constant_model->api_format();
      $post = $this->input->post();
      
      $this->form_validation->set_rules('name', 'Name', 'trim|required');
      $this->form_validation->set_rules('description', 'Description', 'trim|required');
      if ($this->form_validation->run() == false) {
        $result = $this->Constant_model->api_format(0, $this->form_validation->error_array(), 'Failed to insert data');
      } else {
        $created_date = new DateTime();
        $data = array (
          'name' => $post['name'],
          'description' => $post['description'],
          'updated_at' => $created_date->format("Y-m-d H:i:s")
        );
        $response_code = ($this->themes->update($data, $id))?1 : 0;
        $result = $this->Constant_model->api_format($response_code, null, 'Data updated successfuly');
      }
      echo json_encode($result);
    }
    public function delete ($id) {
      
    }
  }
  
?>