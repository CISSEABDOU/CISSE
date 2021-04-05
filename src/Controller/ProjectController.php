<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\component\Validator\Constraints\DateTime;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(): Response
    {
       return $this->render('project/connexion.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
		
		
  
    }
	
	/**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(): Response
    {
        return $this->render('project/registration.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
	
	
	 /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request,EntityManagerInterface $manager):response
    {
		// Récupération des données saisies
		$Nom=$request->request->get("nom");
		$Prenom=$request->request->get("prenom");
		$Email=$request->request->get("email");
		$Mot_de_passe=$request->request->get("password");
		$id=$request->request->get("id");
		
	
		
		//Création d'un objet utilisateur
		
		$monUtilisateur = new Utilisateur();
		
		$monUtilisateur -> setNom($Nom);
		$monUtilisateur -> setPrenom($Prenom);
		$monUtilisateur -> setEmail($Email);
		$monUtilisateur -> setMotDePasse($Mot_de_passe);
		
		//Sotcker l'objet dans la base de données avec la persistance
		$manager->persist($monUtilisateur);
        $manager->flush();
		return new Response("utilisateur créé");
    }
	 /**
     * @Route("/listeUtilisateurs", name="liste_Utilisateurs")
     */
    public function listeUtilisateurs(EntityManagerInterface $manager):response  
    {
	// Affiche la liste de tous les utilisateurs
	$mesUtilisateurs=$manager->getRepository(Utilisateur::class)->findAll();
	//&echo $mesUtilisateurs;
	return $this->render('project/liste_utilisateurs.html.twig',['utilisateurs' => $mesUtilisateurs]);
	}
	/** 
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request,EntityManagerInterface $manager): Response
    {
    //Récupération des identifiants de connexion
    $Email = $request->request->get('login');
    $Mot_de_passe = $request->request->get('password');
    //Test de l'existence d'un tel couple
	echo "<script>alert($Email);</script>";
	//$aUser=$manager->getRepository(Utilisateur::class)->find();//findBy(['mot_de_passe'=>$Mot_de_passe]);
	$aUser=$this->getdoctrine()->getRepository(Utilisateur::class)->findBy(['Email'=>$Email,'Mot_de_passe'=>$Mot_de_passe]);
    if ($aUser!=NULL){
    $utilisateur = new Utilisateur;
    $utilisateur = $aUser[0];
    //démarrage des variables de session
    $sess = $request->getSession();
    //Information de session
    $sess->set("idUtilisateur", $utilisateur->getId());
    $sess->set("nomUtilisateur", $utilisateur->getNom());
    $sess->set("prenomUtilisateur", $utilisateur->getPrenom());
    //echo "<script>alert($sess);</script>";
	if ($Email=="admin@gmail.com")
		   $message="Abdou Aziz Cisse Vous êtes admin";
		else
		   $message="Vous êtes utilisateur";
    return new Response("Bienvenu".$message);
    }else{
     return new Response("Echec authentification");
     }
     
     return new response(1);
     
     }
	
	
    
  
}  
