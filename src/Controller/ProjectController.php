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
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
	/**
     * @Route("/listeutilisateur", name="listeutilisateur")
     */
    public function listeutilisateur(): Response
    {
        return $this->render('project/listeutilisateur.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
	
	
	 /**
     * @Route("/registration", name="registration")
     */
    public function registration(LoggerInterface $logeer,Request $request,EntityManagerInterface $manager):response
    {
		// Récupération des données saisies
		$Nom=$request->request->get("nom");
		$Prenom=$request->request->get("prenom");
		$Email=$request->request->get("email");
		$Mot_de_passe=$request->request->get("password");
		$id=$request->request->get("id");
		
		if ($Nom=="admin")
		   $message="Vous êtes admin";
		else
		   $message="Vous êtes utilisateur";
		
		//Création d'un objet utilisateur
		
		$monUtilisateur = new Utilisateur();
		
		$monUtilisateur -> setNom($Nom);
		$monUtilisateur -> setPrenom($Prenom);
		$monUtilisateur -> setEmail($Email);
		$monUtilisateur -> setMotDePasse($Mot_de_passe);
		
		//Sotcker l'objet dans la base de données avec la persistance
		$manager->persist($monUtilisateur);
        $manager->flush();
    }
}
