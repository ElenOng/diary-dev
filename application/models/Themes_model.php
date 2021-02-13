<?php defined('BASEPATH') OR exit('No direct script are allowed');

class Themes_model extends CI_model
{
  private $table = 'themes';
  
  public function getData ($post = null) {
    $result = null;
    if ($post['theme_id'] == null && $post['search'] == null && $post["deleted"] == 0) {
      $this->db->where('deleted_at', null);
      $result = $this->db->get($this->table)->result();
    }
    elseif ($post['theme_id'] == null && $post['search'] == null && $post["deleted"] == 1) {
      $result = $this->db->get($this->table)->result();
    } else {
      if ($post['theme_id'] == null) {
        $data = array (
          'name' => $post['search'],
          'description' => $post['search']
        );
        $this->db->or_like($data);
        $result = $this->db->get($this->table)->result();

      } else {
        $data = array ('theme_id' => $post['theme_id']);
        $this->db->where($data);
        $result = $this->db->get($this->table)->row();
      }
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

  public function update ($data = null, $id = null) {
    $result = null;
    if ($data != null || $id != null) {
      $result = $this->db->update($this->table, $data, array ('theme_id' => $id));
    }
    return $result;
  }
  public function delete ($data = null) {
    $result = null;
    if ($data != null) {
      $deleted_date = new DateTime();
      $result = $this->db->update($this->table, array ('deleted_at' => $deleted_date->format("Y-m-d H:i:s")), $data);
    }
    return $result;
  }
  
}
