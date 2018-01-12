<?php

namespace MyApp\UserBundle\Controller;
use MyApp\UserBundle\Entity\User;
use MyApp\UserBundle\Entity\MembreContact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class suivreController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    public function suivremembreAction($id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom=$user->getNom();
            $user_prenom=$user->getPrenom();
        }

        $Membrecontact=new MembreContact();
        $membre_conecte=$user_nom.''.$user_prenom;
        $em = $this->getDoctrine()->getManager();
        $sender=$em->getRepository("MyAppUserBundle:User")->findOneById($userId);

        $Membrecontact->setMembre($sender);

        $receiver=$em->getRepository("MyAppUserBundle:User")->findOneById($id);
        $sender=$em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $Membrecontact->setMembreami($receiver);


        $em->persist($Membrecontact);
        $em->flush();

        $Membrecontact2=new MembreContact();

        $em = $this->getDoctrine()->getManager();


        $Membrecontact2->setMembreami($sender);

        $receiver=$em->getRepository("MyAppUserBundle:User")->findOneById($id);
        $Membrecontact2->setMembre($receiver);


        $em->persist($Membrecontact2);
        $em->flush();


        return $this->redirectToRoute('security_show_profile');
    }
    public function supprimerAction($id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('DELETE FROM MyAppUserBundle:MembreContact mc WHERE mc.membre = :id1 AND mc.membreami = :id2 ');
        $query->setParameter('id1', $userId)
            ->setParameter('id2', $id);
        $query->execute();

        $query2 = $em->createQuery('DELETE FROM MyAppUserBundle:MembreContact mc WHERE mc.membre = :id1 AND mc.membreami = :id2 ');
        $query2->setParameter('id1', $id)
            ->setParameter('id2', $userId);
        $query2->execute();

        return $this->redirectToRoute('security_show_profile');}
}