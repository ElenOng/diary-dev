<?php defined('BASEPATH') OR exit('No direct script are allowed');

class Themes_model extends CI_model
{
  private $table = 'themes';
  
  public function getData ($post = null) {
    $result = null;
    if ($post['theme_id'] == null && $post['search'] == null) {
      $result = $this->db->get($this->table)->result();
    } else {
      if ($post['theme_id'] == null) {
        $data = array (
          'name' => $post['search'],
          'description' => $post['search']
        );
        $this->db->or_like($data);
      } else {
        $data = array ('theme_id' => $post['theme_id']);
        $this->db->where($data);
      }
      $result = $this->db->get($this->table)->row();
    }
    return $result;
  }

  public function insert ($post = null) {
    $result = null;
    if ($post != null) {
      $result = $this->db->insert($this->table, $post);
    }
    return $result;
  }
  
}
