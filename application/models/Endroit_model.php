<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Endroit_model extends CI_Model {

	public function get_endroit(){
     	$this->db->select('*');
        $this->db->from('endroit');
		return $this->db->get()->result_array();
        } 
    public function insert_endroit($ville,$image,$description){
         $data = array(
            'ville' => $ville,
            'image' => $image,
            'description' => $description);
       $this->db->insert('endroit',$data);
       return $this->db->insert_id();
        }
    public function get_endroitById($id){
        $this->db->select('*');
        $this->db->where('endroit_id',$id);
        $this->db->from('endroit');
        return $this->db->get()->result_array();
        }
    public function get_endroitByVille($ville){
        $this->db->select('*');
        $this->db->where('ville',$ville);
        $this->db->from('endroit');
        return $this->db->get()->result_array();
        }
    public function update_endroit($id,$data)
        {
        $this->db->where('endroit_id',$id);
        $this->db->update('endroit',$data);
        }
    public function delete_endroit($id)
        {
        
        $this->db->where('endroit_id',$id);
        $this->db->delete('endroit');
        }
  }
?>