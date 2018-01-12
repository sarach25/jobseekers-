<?php

namespace MyApp\UserBundle\Controller;
use MyApp\UserBundle\Entity\OffreEmp;
use MyApp\UserBundle\Entity\Entreprise;
use MyApp\UserBundle\Form\EntrepriseForm;
use MyApp\UserBundle\Form\EntreprisesForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class EntrepriseController extends Controller
{
    /**
     * @Route("/entreprise/ajouts", name="app_entreprise")
     */

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }



    public function ListeEntrepriseAction(Request $request)
    {
        $ent =$request->get('nomentreprise');
        $em=$this->getDoctrine()->getManager();

        $dql = "SELECT p FROM MyAppUserBundle:Entreprise p";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 6)/*limit per page*/
        );
        $entreprise=$em->getRepository("MyAppUserBundle:Entreprise")->findAll();
        $others=$em->getRepository('MyAppUserBundle:Entreprise')->findlike($ent);
        $pics=array();
        foreach ($entreprise as $e ){
            if ( $e->getImgentreprise()!=null)
            {
                $pics[$e->getId()]=base64_encode(stream_get_contents($e->getImgentreprise()));

            }


        }

        return $this->render('MyAppUserBundle:Entreprise:Liste_Enreprise.html.twig', array('entreprise'=>$entreprise,'pics'=>$pics,'others'=>$others,'pagination' =>$pagination ));
    }







    public function AfficheEntrepriseAction(Request $request)
    {
        $ent =$request->get('nomentreprise');


        $em=$this->getDoctrine()->getManager();
        $dql = "SELECT p FROM MyAppUserBundle:Entreprise p";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 6)/*limit per page*/
        );

        $entreprise=$em->getRepository("MyAppUserBundle:Entreprise")->findAll();

        $others=$em->getRepository('MyAppUserBundle:Entreprise')->findlike($ent);

        $pics=array();
        foreach ($entreprise as $e ){
            if ( $e->getImgentreprise()!=null)
            {
                $pics[$e->getId()]=base64_encode(stream_get_contents($e->getImgentreprise()));

            }


        }

        return $this->render('MyAppUserBundle:Entreprise:Affiche_Entreprise.html.twig', array('entreprise'=>$entreprise,'pics'=>$pics ,'pagination' =>$pagination,'others'=>$others));
    }








    public function AjoutEntrepriseAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userId = $this->getUser()->getId();

    }
        $entreprise= new Entreprise();
        $form = $this->createForm(EntrepriseForm::class, $entreprise);
        $form->handleRequest($request);
        if($request->isMethod('POST'))
        {$entreprise->setNomentreprise($request->get('nomentreprise'));
            $entreprise->setDomaine($request->get('domaine'));
            $entreprise->setAdresse($request->get('adresse'));
            $entreprise->setMembre($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            return$this->redirectToRoute('Liste_Entreprise');

        }

        return $this->render('MyAppUserBundle:Entreprise:Ajout_Entreprise.html.twig', array());
    }



    public function DeleteEntrepriseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entreprise=$em->getRepository('MyAppUserBundle:Entreprise')->find($id);
        $em->remove($entreprise);



        $em->flush();
        return$this->redirectToRoute('Liste_Entreprise');


    }
    public function UpdateEntrepriseAction($id, Request $request)

    {

        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $this->getUser()->getId();

        }
        $em = $this->getDoctrine()->getManager();
        $entreprise=$em->getRepository("MyAppUserBundle:Entreprise")->find($id);
        $Form=$this->createForm(EntrepriseForm::class,$entreprise);
        $Form->handleRequest($request);
        if($Form->isValid())
        {$entreprise->setMembre($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            return$this->redirectToRoute('Liste_Entreprise');

        }
        return $this->render('MyAppUserBundle:Entreprise:Update_Entreprise.html.twig', array('formes'=>$Form->createView()));


    }
    public function rechercheAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $pics=array();

        $text=$request->get('text');
        $entreprise_nomentreprise=$em->getRepository("MyAppUserBundle:Entreprise")->findBy(array('nomentreprise'=>$text));
        $entreprise_domaine=$em->getRepository("MyAppUserBundle:Entreprise")->findBy(array('domaine'=>$text));
        $entreprise_adresse=$em->getRepository("MyAppUserBundle:Entreprise")->findBy(array('adresse'=>$text));




        $dql = "SELECT p FROM MyAppUserBundle:Entreprise p";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 6)/*limit per page*/
        );


        $entreprise=$em->getRepository("MyAppUserBundle:Entreprise")->findAll();
        foreach ($entreprise as $e ){
            if ( $e->getImgentreprise()!=null)
            {
                $pics[$e->getId()]=base64_encode(stream_get_contents($e->getImgentreprise()));

            } }
        $others=$em->getRepository('MyAppUserBundle:Entreprise')->findlike($text);


        return $this->render('MyAppUserBundle:Entreprise:recherche.html.twig',
            array('nomentreprise'=>$entreprise_nomentreprise,'domaine'=>$entreprise_domaine,'adresse'=>$entreprise_adresse,'pics'=>$pics,'others'=>$others,'pagination' =>$pagination ));

    }
    public function pageAction( $id ,Request $request)
    {
        $ent =$request->get('nomentreprise');

        $em=$this->getDoctrine()->getManager();

        $entreprise=$em->getRepository("MyAppUserBundle:Entreprise")->findOneById($id);

        $others=$em->getRepository('MyAppUserBundle:Entreprise')->findlike($ent);

        return $this->render('MyAppUserBundle:Entreprise:page.html.twig', array('entreprise'=>$entreprise,'others'=>$others));
    }


public function ajoutsAction(Request $request){

    $entreprise = new Entreprise();
    $Form = $this->createForm(EntreprisesForm::class,$entreprise);
    $Form->handleRequest($request);
    if($Form->isSubmitted() && $Form->isValid())
    {
        /** @ORM Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $entreprise->getImgentreprise();

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(
            $this->getParameter('images_directory'),
            $fileName
        );

        $entreprise->setImgentreprise($fileName);
        $em=$this->getDoctrine()->getManager();
        $em->persist($entreprise);
        $em->flush();
        return $this->redirectToRoute($this->genrateUrl('Liste_Entreprise'));

    }
        return $this->render("MyAppUserBundle:Entreprise:ajout3.html.twig",array('form'=>$Form->createView()));




}

}
