<?php defined('BASEPATH') OR exit('No direct script are allowed');
  class Constant_model extends CI_Model
  {
    // used for API Formating
    public function api_format ($response_code = 0, $data = null, $message = 'default message') {
      $result = array (
        'response_code' => $response_code,
        'data' => $data,
        'message' => $message
      );
      return $result;
    }
    // used for id generating
    public function generate_id ($table = null, $prefix = null) {
      $result = null;
      if ($table != null && $prefix != null) {
        $data = $this->db->count_all_results($table);
        $result = $prefix . str_pad($data + 1, 7, '0', STR_PAD_LEFT);
      }
      return $result;
    }
  }
  
?>