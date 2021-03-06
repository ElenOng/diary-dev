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
      $postdata = json_decode($this->input->post("postdata"));
      $data = array (
        "theme_id" => $postdata->data->theme_id,
        "search" => $postdata->data->search,
        "deleted" => $postdata->data->delete
      );
      $result["data"] = $this->themes->getData($data);
      $result["response_code"] = ($result["data"] != null)? 1 : 0;
      $result["message"] = "Themes data loaded successfuly";

      echo json_encode($result);
    }

    public function insert () {
      $result = $this->Constant_model->api_format();
      
      $postdata = json_decode($this->input->post("postdata"));
      $post = array (
        "name" => $postdata->data->name,
        "description" => $postdata->data->description
      );
      
      $_POST["name"] = $post["name"];
      $_POST["description"] = $post["description"];

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
      $postdata = json_decode($this->input->post("postdata"));
      $post = array (
        "name" => $postdata->data->name,
        "description" => $postdata->data->description
      );
      
      $_POST["name"] = $post["name"];
      $_POST["description"] = $post["description"];
      
      $this->form_validation->set_rules('name', 'Name', 'trim|required');
      $this->form_validation->set_rules('description', 'Description', 'trim|required');
      if ($this->form_validation->run() == false) {
        $result = $this->Constant_model->api_format(0, $this->form_validation->error_array(), 'Failed to insert data');
      } else {
        $updated_date = new DateTime();
        $data = array (
          'name' => $post['name'],
          'description' => $post['description'],
          'updated_at' => $updated_date->format("Y-m-d H:i:s")
        );
        $response_code = ($this->themes->update($data, $id))?1 : 0;
        $result = $this->Constant_model->api_format($response_code, null, 'Data updated successfuly');
      }
      echo json_encode($result);
    }
    public function delete ($id) {
      $result = $this->Constant_model->api_format();
      $post = $this->input->post();

      $data = array ('theme_id' => $id);
      $response_code = ($this->themes->delete($data))?1 : 0;
      $result = $this->Constant_model->api_format($response_code, null, 'Data deleted  successfuly');

      echo json_encode($result);
    }
  }
  
?>