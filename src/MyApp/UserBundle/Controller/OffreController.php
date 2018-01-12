<?php

namespace MyApp\UserBundle\Controller;
use MyApp\UserBundle\Entity\Entreprise;
use MyApp\UserBundle\Entity\Competance;
use MyApp\UserBundle\Entity\OffreEmp;
use MyApp\UserBundle\Form\OffreForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MyApp\UserBundle\Repository\OffreRepository;


class OffreController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function ListeAction(Request $request)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userId = $this->getUser()->getId();



    }

        $em=$this->getDoctrine()->getManager();
        $dql = "SELECT p FROM MyAppUserBundle:OffreEmp p";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 6)/*limit per page*/
        );
        $offre=$em->getRepository("MyAppUserBundle:OffreEmp")->findAll();
        return $this->render('MyAppUserBundle:Offre:Offre_liste.html.twig', array('pagination' =>$pagination ));


    }
    public function TryAction()
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $this->getUser()->getId();



        }
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MyAppUserBundle:OffreEmp")->findAll();
        return $this->render('MyAppUserBundle:Offre:try.html.twig', array('offre'=>$offre ));


    }
    public function AfficheOffreAction(Request $request)
    {
        $ent =$request->get('nomentreprise');
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $this->getUser()->getId();
        }
        $em=$this->getDoctrine()->getManager();
        $others=$em->getRepository('MyAppUserBundle:Entreprise')->findlike($ent);
        $offre=$em->getRepository("MyAppUserBundle:OffreEmp")->findAll();
        return $this->render('MyAppUserBundle:Offre:AfficheOffre.html.twig', array('offre'=>$offre,'others'=>$others ));


    }
    public function AfficheOffre1Action( Request $request)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $this->getUser()->getId();
        }

        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MyAppUserBundle:OffreEmp")->findAll();

        $ent =$request->get('nomentreprise');

        $entreprises= array();
        foreach ($offre as $o )
        {
            $entreprises[$o->getId()]=$em->getRepository("MyAppUserBundle:Entreprise")->findOneBy(array('nomentreprise'=>$o->getNomentreprise()));
        }
        $others=$em->getRepository('MyAppUserBundle:Entreprise')->findlike($ent);
        return $this->render('MyAppUserBundle:Offre:affOffre.html.twig', array('offre'=>$offre,'en'=>$entreprises,'others'=>$others ));


    }
    public function AjoutAction(Request $request)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $this->getUser()->getId();

 }
        $offre= new OffreEmp();
        $Form = $this->createForm(OffreForm::class ,$offre);
        $Form->handleRequest($request);
        if( $Form->isValid() )

        {

            $offre->setMembre($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return$this->redirectToRoute('Liste_Offre');

        }

        return $this->render('MyAppUserBundle:Offre:Ajout_ofre.html.twig', array('formes'=>$Form->createView()));
    }




    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $offre=$em->getRepository('MyAppUserBundle:OffreEmp')->find($id);
        $em->remove($offre);


        $em->flush();
        return$this->redirectToRoute('Liste_Offre');


    }

    public function UpdateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $offre=$em->getRepository("MyAppUserBundle:OffreEmp")->find($id);
        $Form=$this->createForm(OffreForm::class,$offre);
        $Form->handleRequest($request);
        if($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return$this->redirectToRoute('Liste_Offre');

        }
        return $this->render('MyAppUserBundle:Offre:Update_Offre.html.twig', array('formes'=>$Form->createView()));


    }

    public function rechercheOffreAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();



        $text=$request->get('text');
        $offre_nomentreprise=$em->getRepository("MyAppUserBundle:OffreEmp")->findBy(array('nomentreprise'=>$text));
        $offre_domaine=$em->getRepository("MyAppUserBundle:OffreEmp")->findBy(array('domaine'=>$text));
        $offre_poste=$em->getRepository("MyAppUserBundle:OffreEmp")->findBy(array('poste'=>$text));
        $offre_contenu=$em->getRepository("MyAppUserBundle:OffreEmp")->findBy(array('contenu'=>$text));
        $offre=$em->getRepository("MyAppUserBundle:OffreEmp")->findAll();



        return $this->render('MyAppUserBundle:Offre:recherche_offre.html.twig',
            array('nomentreprise'=>$offre_nomentreprise,'domaine'=>$offre_domaine,'poste'=>$offre_poste,'contenu'=>$offre_contenu));

    }

    public function ajoutrecomAction(Request $request)
    {

        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $this->getUser()->getId();

        }
        $offre= new OffreEmp();
        $competence = new Competance();

        $Form = $this->createForm(OffreForm::class ,$offre);
        $Form->handleRequest($request);
        if( $Form->isValid() )

        {

            $offre->setMembre($user);
            $lm=$this->getDoctrine()->getManager();
            $em=$this->getDoctrine()->getManager();

            $d =$offre->getId();
            $s = $offre->getNomentreprise();
            $competence->setNomCompetance($s);
            $competence->setIdComp($d);

            $em->persist($offre);
         $em->flush();
            $lm->persist($competence);
            $lm->flush();


            return$this->redirectToRoute('Liste_Offre');

        }

        return $this->render('MyAppUserBundle:Offre:affOffre.html.twig', array('formes'=>$Form->createView()));
    }




}
