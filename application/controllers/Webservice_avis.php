<?php
 
require APPPATH.'/libraries/REST_Controller.php';
 
class webservice_avis extends REST_Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Avis_model','avis');
        $this->load->model('Utilisateur_model','utilisateur');
        $this->output->set_content_type('application/json');
        header('Access-Control-Allow-Origin:*');
    }
    /*Web service insertion avis
      Method : POST
      Params : utilisateur_id,endroit_id,note,commentaire
      URL : IP/Webservice_avis/insertAvis
     */ 
    public function insertAvis_post(){

        $utilisateur_id = $this->post('utilisateur_id');
        $endroit_id = $this->post('endroit_id');
        $note = $this->post('note');
        $commentaire = $this->post('commentaire');
        $donnees = array();
        $result = $this->avis->insert_avis($utilisateur_id,$endroit_id,$note,$commentaire);
        if ($result) {
            $donnees['status'] = "OK";
            $donnees['message'] = "Avis enregistre avec succès";
            $donnees['user'] =  $this->utilisateur->get_list_userById($utilisateur_id);
            $res = json_encode($donnees);
            $this->output->set_output($res);
        } else {
            $donnees['status'] = "KO";
            $donnees['message'] = "Avis n'est pas enregistre.Veuillez le ressaisir!";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
     }
     /*Web service modification avis
      Method : PUT
      Params : utilisateur_id,endroit_id,note,commentaire
      URL : IP/Webservice_avis/update_avis
     */ 
    public function update_avis_put($id)
     {

      $utilisateur_id = $this->put('utilisateur_id');
      $endroit_id = $this->put('endroit_id');
      $note = $this->put('note');
      $commentaire = $this->put('commentaire');

      $data_update = array();

     if((isset($utilisateur_id) && !empty($utilisateur_id)) && (isset($endroit_id) && !empty($endroit_id)) && (isset($note) && !empty($note)) && (isset($commentaire) && !empty($commentaire)))
        {
            $data_update['avis_id'] = $id;
            $data_update['utilisateur_id'] =  $utilisateur_id;
            $data_update['endroit_id'] = $endroit_id;
            $data_update['note'] = $note;
            $data_update['commentaire'] = $commentaire;
            $this->avis->update_Avis($id,$data_update);
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
   /*Web service liste avis
      Method : GET
      URL : IP/Webservice_avis/list_avis
     */ 
    public function list_avis_get()
    {
		$listdata = $this->avis->get_avis();
		if($listdata){
			$donnees = array();
			$i=0;
			$avs = array();
			foreach ($listdata as $cur_avisdata){
				$data = array();
				$data['id'] = $cur_avisdata['avis_id'];
				$data['user_id'] = $cur_avisdata['utilisateur_id'];
				$data['endroit_id'] = $cur_avisdata['endroit_id'];
				$data['note'] = $cur_avisdata['note'];
				$data['commentaire'] = $cur_avisdata['commentaire'];
				
				$avs[$i] = $data;
				$i++;
			}
			$donnees['Avis'] = $avs;
			$res = json_encode($donnees);
    		$this->output->set_output($res);
		}else{
			$donnees = array();
    		$donnees['status'] = "KO";
    		$donnees['message'] =  "Aucun avis trouvé";
    		$res = json_encode($donnees);
    		$this->output->set_output($res);
		}
    }
    /*Web service liste avis par identifiant
      Method : GET
      Params : id
      URL : IP/Webservice_avis/avis_byId
     */ 
    public function avis_byId_get($id)
    {
        $listdata = $this->avis->get_AvisById($id);
        if($listdata){
            $donnees = array();
            $i=0;
            $avs = array();
            foreach ($listdata as $cur_avisdata){
                $data = array();
                $data['id'] = $cur_avisdata['avis_id'];
                $data['utilisateur_id'] = $cur_avisdata['utilisateur_id'];
                $data['endroit_id'] = $cur_avisdata['endroit_id'];
                $data['note'] = $cur_avisdata['note'];
                $data['commentaire'] = $cur_avisdata['commentaire'];
                
                $avs[$i] = $data;
                $i++;
            }
            $donnees['status'] = "KO";
            $donnees['avis'] = $avs;
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $avis['status'] = "KO";
            $avis['message'] = "L'identifiant que vous avez introduit n'existe pas, veuillez réessaye";
            $res = json_encode($avis);
            $this->output->set_output($res);
        }
    }
   /*Web service supression avis
      Method : DELETE
      Params : id
      URL : IP/Webservice_avis/supp_avis
     */ 
 public function supp_avis_delete($id)
     {
    $endroit = array();

    if((isset($id) && !empty($id))){
      $this->avis->delete_avis($id);
      $endroit['status'] = "OK";
      $endroit['message'] = "Avis supprimer avec succès";
      $res = json_encode($endroit);
      $this->output->set_output($res);
      }
      else{
      $endroit['status'] = "KO";
      $endroit['message'] = "L'identifiant de l'avis que vous avez introduit n'existe pas, veuillez réessaye";
      $res = json_encode($endroit);
      $this->output->set_output($res);
      }
    }
}
?>