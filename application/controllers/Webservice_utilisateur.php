<?php
 
require APPPATH.'/libraries/REST_Controller.php';
 
class webservice_utilisateur extends REST_Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Utilisateur_model','user');
        $this->output->set_content_type('application/json');
    }
    /*Web service inscription d'utilisateur
      Method : POST
      URL : IP/Webservice_utilisateur/inscription
     */ 
    public function inscription_post(){

        $nom= $this->post('nom');
        $email = $this->post('email');
        $password = $this->post('password');
        $genre = $this->post('genre');
        $date_anniv = $this->post('date_anniversaire');

        $donnees = array();
        $result = $this->user->insert_user($nom,$email,$password, $genre,$date_anniv);
        if ($result == USER_CREATED)
        {
            $donnees['status'] = "OK";
            $donnees['message'] = "L’inscription s’est effectuée avec succès";
            $donnees['user'] =  $this->user->get_userByEmail($email);
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
         elseif ($result == USER_CREATION_FAILED) {
            $donnees['status'] = "KO";
            $donnees['message'] = "L'information que vous avez saisi n’est pas correct. Veuillez le réessayer!";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        
        } elseif ($result == USER_EXIST) {
            $donnees['status'] = "KO";
            $donnees['message'] = "L'email que vous avez saisi existe déjà.Veuillez le réessayer!";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
    }
    /*Web service login d'utilisateur
      Method : POST
      Params : email,password
      URL :IP/Webservice_utilisateur/login
     */ 
   public function login_post(){
        $data = $this->user->get_user_login($this->post('email'),$this->post('password'));
        if ($data){
            $donnees = array();
            $donnees['status'] = "OK";
            $donnees['user'] = $this->user->get_userByEmail($this->post('email'));
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $donnees = array();
            $donnees['status'] = "KO";
            $donnees['message'] =  "Login ou mot de passe incorrect";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }     
      }
    /*Web service modification d'utilisateur
      Method : PUT
      Params : nom,email,password,genre,date_anniversaire
      URL : IP/Webservice_utilisateur/updateUser/{id}
     */ 
    public function updateUser_put($id)
     {
      $nom  = $this->put('nom');
      $email = $this->put('email');
      $password = md5($this->put('password'));
      $genre = $this->put('genre');
      $date_anniversaire = $this->put('date_anniversaire');
     
     $data_update = array();

     if((isset($nom) && !empty($nom)) && (isset($email) && !empty($amail)) && (isset($genre) && !empty($genre)) && (isset($date_anniversaire) && !empty($date_anniversaire)))
        {
            $data_update['utilisateur_id'] = $id;
            $data_update['nom'] =  $nom;
            $data_update['email'] =  $email;
            $data_update['password'] = $password;
            $data_update['genre'] =  $genre;
            $data_update['date_anniversaire'] = $date_anniversaire;
        }
          
    if (!$this->user->update_pass($id,$data_update)){
            $donnees = array();
            $donnees['status'] = "OK";
            $donnees['message'] = "Utilisateur a été modifier avec succès.";
            $donnees['user'] = $this->user->get_userByEmail($email);

            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $donnees = array();
            $donnees['status'] = "KO";
            $donnees['message'] =  "L'information que vous avez saisi n’est pas correct. Veuillez réessayer !";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
    }
   /*Web service modification d'utilisateur
      Method : GET
      URL : IP/Webservice_utilisateur/list_user/{id}
   */ 
  public function list_user_get()
    {
		$listdata = $this->user->get_list_user();
		if($listdata){
			$donnees = array();
			$i=0;
			$usr = array();
			foreach ($listdata as $cur_userdata){
				$userdata = array();
				$userdata['id'] = $cur_userdata['utilisateur_id'];
				$userdata['nom'] = $cur_userdata['nom'];
        $userdata['mail'] = $cur_userdata['email'];
				$userdata['genre'] = $cur_userdata['genre'];
				$userdata['anniversaire'] = $this->date_en_to_fr($cur_userdata['date_anniversaire']);
				$usr[$i] = $userdata;
				$i++;
			}
			$donnees['users'] = $usr;
			$res = json_encode($donnees);
    		$this->output->set_output($res);
		}else{
			$donnees = array();
    		$donnees['status'] = "KO";
    		$donnees['message'] =  "Aucun utilisateur trouvé";
    		$res = json_encode($donnees);
    		$this->output->set_output($res);
		}
   }
    /*Web service modification mots de passe d'utilisateur
      Method : POST
      Params : email,password
      URL : IP/Webservice_utilisateur/list_user/{id}
     */ 
    public function modifPasswordByEmail_post()
     {

      $email =$this->post('email');
      $password = $this->post('password');
      $data_update = array();

     if((isset($email) && !empty($email)) && (isset($password) && !empty($password))) {

            $data_update['email'] = $email;
            $data_update['password'] = $password;
        }   
    if (!$this->user->passwordByEmail($email,$data_update)){
            $donnees = array();
            $donnees['status'] = "OK";
            $donnees['message'] = "Votre mot de passe a été réinitialisé avec succès!";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }else{
            $donnees = array();
            $donnees['status'] = "KO";
            $donnees['message'] =  "La réponse vous avez saisi n’est pas correcte. Veuillez la ressaisir !";
            $res = json_encode($donnees);
            $this->output->set_output($res);
        }
     }
   /*Web service modification mots de passe d'utilisateur
      Method : GET
      Params : id
      URL : IP/Webservice_utilisateur/list/{id}
     */ 
    public function list_get($id)
       {
        $listdata = $this->user->get_list_userById($id);
        if($listdata){
            $users = array();
            $i=0;
            $donnees = array();
            foreach ($listdata as $data){
                $userdata = array();
                $userdata['id'] = $data['utilisateur_id'];
                $userdata['nom'] = $data['nom'];
                $userdata['mail'] = $data['email'];
                $userdata['genre'] = $data['genre'];
                $userdata['anniversaire'] = $data['date_anniversaire'];

                $donnees[$i] = $userdata;
                $i++;
            }
            $users['users'] = $donnees;
            $res = json_encode($users);
            $this->output->set_output($res);
        }else{
         $donnees = array();
        $donnees['status'] = "KO";
        $donnees['message'] =  "Aucun utilisateur trouvé";
        $res = json_encode($donnees);
        $this->output->set_output($res);
      }
    }
//Convertion date d'anniversaire en français
function date_en_to_fr($date_to_convert, $separator_en = "-", $separtor_fr = "/")
  {
    if ($date_to_convert && isset($date_to_convert)) {

        $tab = explode($separator_en, $date_to_convert);
        if (count($tab) == 3) {
            $res = $tab[2] . $separtor_fr . $tab[1] . $separtor_fr . $tab[0];
            return $res;
        }
    }
    return $date_to_convert;
  }
}
?>