<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Utilisateur;
Use App\Form\InscriptionType;
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
     * @Route("/registration", name="registration")
     */
    public function registration()
    {
		$user = new Utilisateur();
		$form = $this->createForm(InscriptionType::class, $user);
        return $this->render('project/registration.html.twig', [ 
		    'form' => $form->createView()
		]);
    }
	
}
