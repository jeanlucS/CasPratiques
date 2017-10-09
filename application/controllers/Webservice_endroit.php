<?php
 
require APPPATH.'/libraries/REST_Controller.php';
 
class webservice_endroit extends REST_Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Endroit_model','endroit');
        $this->output->set_content_type('application/json');
    }
    public function isertEndroit_post(){

        $ville = $this->post('ville');
        $image = $this->post('image');
        $description = $this->post('description');

        $donnees = array();
        $result = $this->endroit->insert_endroit($ville,$image,$description);
        if ($result) {
            $donnees['status'] = "OK";
            $donnees['message'] = "Endroit enregistre avec succès";
            $donnees['endroit'] =  $this->endroit->get_endroitByVille($ville);
            $res = json_encode($donnees);
            $this->output->set_output($res);
        } else {
            $donnees['status'] = "KO";
            $donnees['message'] = "Endroit n'est pas enregistre.Veuillez le ressaisir!";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
     }
    public function update_endroit_put($id)
     {

      $ville = $this->put('ville');
      $image = $this->put('image');
      $description = $this->put('description');
      $data_update = array();

     if((isset($ville) && !empty($ville)) && (isset($image) && !empty($image)) && (isset($description) && !empty($description)))
        {
            $data_update['endroit_id'] = $id;
            $data_update['ville'] =  $ville;
            $data_update['description'] = $description;
        } 

    if (!$this->endroit->update_endroit($id,$data_update)){
            $donnees = array();
            $donnees['status'] = "OK";
            $donnees['message'] = "Modification avis avec succès.";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $donnees = array();
            $donnees['status'] = "KO";
            $donnees['message'] =  "L'information que vous avez saisi n’est pas correct. Veuillez le réessayer !";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
    }
    public function list_endroit_get()
    {
        $listdata = $this->endroit->get_endroit();
        if($listdata){
            $donnees = array();
            $i=0;
            $endroit = array();
            foreach ($listdata as $cur_endroitdata){
                $data = array();
                $data['id'] = $cur_endroitdata['endroit_id'];
                $data['ville'] = $cur_endroitdata['ville'];
                $data['image'] = $cur_endroitdata['image'];
                $data['description'] = $cur_endroitdata['description'];
               
                $endroit[$i] = $data;
                $i++;
            }
            $donnees['status'] = "KO";
            $donnees['endroit'] = $endroit;
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $donnees = array();
            $donnees['status'] = "KO";
            $donnees['message'] =  "Aucun endroit trouvé";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
    }
    //
    public function endroit_byId_get($id)
    {
        $listdata = $this->endroit->get_endroitById($id);
        if($listdata){
            $donnees = array();
            $i=0;
            $endroit = array();
            foreach ($listdata as $cur_endroitdata){
                $data = array();
                $data['id'] = $cur_endroitdata['endroit_id'];
                $data['ville'] = $cur_endroitdata['ville'];
                $data['image'] = $cur_endroitdata['image'];
                $data['description'] = $cur_endroitdata['description'];
               
                $endroit[$i] = $data;
                $i++;
            }
            $donnees['status'] = "KO";
            $donnees['endroit'] = $endroit;
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $donnees = array();
            $donnees['status'] = "KO";
            $donnees['message'] =  "Aucun endroit trouvé pour cette identifiant";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
    }
    public function endroitdel_delete($id)
    {
    
    $resultat = $this->endroit->delete_endroit($id);
    var_dump($resultat);die();
    if($resultat)
      {
      $endroit = array();
      $endroit['status'] = "OK";
      $endroit['message'] = "Endroit supprimer avec succès";
      $res = json_encode($endroit);
      $this->output->set_output($res);
      }else{
      $endroit['status'] = "KO";
      $endroit['message'] = "L'identifiant de l'endroit que vous avez introduit n'existe pas, veuillez réessaye";
      $res = json_encode($endroit);
      $this->output->set_output($res);
      }
    }
 }
 ?>