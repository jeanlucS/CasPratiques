<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur_model extends CI_Model {

    public function insert_user($nom,$email,$password, $genre,$date_anniv)
    {
     $res = $this->isUserExist($email);
        if (!$res) {
         $data = array(
             'nom' => $nom,
             'email' => $email,
             'password' => $password,
             'genre' => $genre,
             'date_anniversaire' => $date_anniv);
             if ($this->db->insert('utilisateur', $data)) {
                 return USER_CREATED;
             }else{
                return USER_CREATION_FAILED;
             }
        }else{
         return USER_EXIST;
       }
      }
    public function get_user_login($email,$pass){
        $this->db->select('*');
        $this->db->from('utilisateur');
        $this->db->where('email', $email);
        $this->db->where('password', $pass);
        $this->db->limit(1);
        return $this->db->get()->row_array();

    }
	public function get_userByEmail($email){
        $this->db->select('*');
        $this->db->from('utilisateur');
        $this->db->where('email',$email);
       return $this->db->get()->row_array();

    }
    public function get_list_user()
    {
        $this->db->select("utilisateur_id,nom,email,genre,date_anniversaire");
        $this->db->from('utilisateur');
        return $this->db->get()->result_array();
    }
    public function get_list_userById($id)
       {
        $this->db->select("utilisateur_id,nom,email, genre,date_anniversaire");
        $this->db->where('utilisateur_id',$id);
        $this->db->from('utilisateur');
        return $this->db->get()->result_array();
      }
    public function update_user($id,$data)
      {  
        $this->db->where('utilisateur_id',$id);
        $this->db->update('utilisateur',$data);
     }
    public function update_passwordByEmail($email)
      {  
        $this->db->where('email',$email);
        $this->db->update('utilisateur',$data);
      }
    public function delete_avis($id)
      {
        $this->db->where('utilisateur_id',$id);
        $this->db->delete('utilisateur');
     }
  function isUserExist($email)
    {
        $sql = "SELECT utilisateur_id FROM utilisateur WHERE email = LOWER('".$email."')";
        if ($this->db->query($sql)->num_rows()) {
            return true;
        }else{
            return false;
        }
    }
}
?>