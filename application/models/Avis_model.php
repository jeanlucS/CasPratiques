<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avis_model extends CI_Model {

	public function insert_avis($utilisateur_id,$endroit_id,$note,$commentaire)
         {
            $data = array(
            'utilisateur_id' => $utilisateur_id,
            'endroit_id' => $endroit_id,
            'note' => $note,
            'commentaire' => $commentaire
           );
           return $this->db->insert('avis',$data);
          } 
    public function get_avis(){
            $this->db->select('*');
            $this->db->from('avis');
            return $this->db->get()->result_array();
           }
    public function get_AvisById($id)
            {
            $this->db->select('*');
            $this->db->where('avis_id',$id);
            $this->db->from('avis');
            return $this->db->get()->result_array();
            }

    public function update_Avis($id,$data)
        {
        $this->db->where('avis_id',$id);
        $this->db->update('avis',$data);
        }
     public function delete_avis($id)
        {
        $this->db->where('avis_id',$id);
        $this->db->delete('avis');
        }
    }
?>