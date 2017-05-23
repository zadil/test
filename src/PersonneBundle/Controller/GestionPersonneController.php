<?php

namespace PersonneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PersonneBundle\Entity\Personne;
use PersonneBundle\Entity\Memo;
use Symfony\Component\HttpFoundation\Request;
use PersonneBundle\Form\PersonneType;
use PersonneBundle\Form\ConnexionType;
use PersonneBundle\Form\RechercheType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GestionPersonneController extends Controller
{
    /**
     * @Route("/lister" , name="listerPersonne")
     */
    public function listerAction()
    {
      $listePersonne = $this->getDoctrine()->getManager()->getRepository('PersonneBundle:Personne')->findSortedByName();  
        return $this->render('PersonneBundle:GestionPersonne:lister.html.twig', array("listePersonne" => $listePersonne,
            // ...
        ));
    }


    /**
     * @Route("/show/{id}/{page}" , name="showPersonne")
     */
    public function showAction(Personne $personne , Request $request, $page)
    {
      
        $memo= new Memo();
        $form=$this->createFormBuilder($memo)
        ->add('contenu', TextType::class, array('label' => 'contenu'))
        ->add('soumettre', SubmitType::class, array('label' => 'soumettre'))
        ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $memo->setDateCreation(new \datetime());
            $memo->setFait(false);
            $memo->setPersonne($personne);
            $em=$this->getDoctrine()->getManager();
            $em->persist($memo);
            $em->flush();

            return $this->redirectToRoute('showPersonne', array("id" => $personne->getId(),'page' => '0'
            // ...
        ));

        }

        $paginationMemos=$this->getDoctrine()->getManager()->getRepository('PersonneBundle:Memo')->paginationMemosvPersonne($page,$personne);
        return $this->render('PersonneBundle:GestionPersonne:afficher.html.twig', array("personne" => $personne, 'form' => $form->createView(), 'paginationMemos' =>  $paginationMemos,
            // ...
        ));
    }

    /**
     * @Route("/supprimer/{id}" , name="supprimerPersonne")
     */
    public function supprimerAction(Personne $personne)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($personne);
        $em->flush();
        return $this->redirectToRoute('listerPersonne', array(
            // ...
        ));
    }

     /**
     * @Route("/supprimerSession" , name="supprimerSession")
     */
    public function supSessionAction(Request $request)
    {
        
        $session = $request->getSession();
        $session->invalidate();

        return $this->redirectToRoute('listerFormation', array(
            // ...
        ));
    }

    /**
     * @Route("/inserer" , name="insererPersonne")
     */
    public function insererAction(Request $request)
    {
        $personne = new Personne();
        $form = $this->get('form.factory')->create(PersonneType::class, $personne);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('recherchePersonne', array(
            // ...
        ));

        }

        return $this->render('PersonneBundle:GestionPersonne:inserer.html.twig', array('form' => $form->createView(),
            // ...
        ));
    }

    /**
     * @Route("/afficher/{id}" , name="afficherDetail")
     */
    public function afficherAction(Personne $personne, Request $request)
    {

      $form = $this->get('form.factory')->create(PersonneType::class, $personne);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('recherchePersonne', array(
            // ...
        ));

        }

        return $this->render('PersonneBundle:GestionPersonne:inserer2.html.twig', array('form' => $form->createView(),
            // ...
        ));
    }

    /* $form=$this->createFormBuilder($personne)
        ->add('nom', TextType::class, array('label' => 'nom'))
        ->add('prenom', TextType::class, array('label' => 'prenom'))
        ->add('genre' , TextType::class , array ('label' => 'genre'))
        ->add('mail' , TextType::class , array ('label' => 'email'))
        ->add('codePostal' , TextType::class, array('label' => 'code postal'))
        ->add('ville' , TextType::class, array('label' => 'ville'))
        ->add('telephone' , TextType::class, array('label' => 'telephone'))
        ->add('photo' , TextType::class, array('label' => 'lien photo'))
        ->add('valider', SubmitType::class)
        ->getForm(); */
    

    /**
     * @Route("/connexion" , name="connexion")
     */
    public function ConnexionAction(Request $request)
    {
    $connexion = array('email' => '' , 'password' => '' );
      $form = $this->get('form.factory')->create(ConnexionType::class, $connexion);
      $form->handleRequest($request);
        if($form->isValid()){
            $connexion = $form->getData();
            $personne=$this->getDoctrine()->getManager()->getRepository('PersonneBundle:Personne')->findOneBy(array('email' => $connexion['email']));
           if($personne->getPassword() == $connexion['password']){
                $session = $request->getSession();
                $session->set('id', $personne->getId());
                $session->set('nom', $personne->getNom());
                $session->set('prenom', $personne->getPrenom());
                //$this->getUser()->setAuthenticated(true);
                //$this->getUser()->setAttribute("nom", $personne->getPersonne());
                //$this->getUser()->setAttribute("login", $prenom->getPrenom());

               return $this->redirectToRoute('recherchePersonne', array(
            // ...
        ));

            }
            else
            {
              return $this->render('PersonneBundle:GestionPersonne:connexion.html.twig', array('form' => $form->createView(),
            // ...
        ));  
            }
        }
        return $this->render('PersonneBundle:GestionPersonne:connexion.html.twig', array('form' => $form->createView(), 'connexion' => $connexion,
            // ...
        ));
    }

    /**
     * @Route("/personne/recherche" , name="recherchePersonne")
     */
    public function RechercheAction(Request $request)
    {
        $recherche = array('recherche' => '',);
      $form = $this->get('form.factory')->create(RechercheType::class, $recherche);
      $form->handleRequest($request);
        if($form->isValid()){
            $recherche = $form->getData();
            $listePersonne=$this->getDoctrine()->getManager()->getRepository('PersonneBundle:Personne')->findByChoixNameOuPrenom(array('recherche' => $recherche['recherche'], ));
            return $this->render('PersonneBundle:GestionPersonne:lister.html.twig', array("listePersonne" => $listePersonne, 'form' => $form->createView(),
            // ...
        ));

            }
        $listePersonne = $this->getDoctrine()->getManager()->getRepository('PersonneBundle:Personne')->findSortedByName();
        return $this->render('PersonneBundle:GestionPersonne:lister.html.twig', array('form' => $form->createView(),"listePersonne" => $listePersonne,
            // ...
        ));  
    }
        

}
