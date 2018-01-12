<?php

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\Competance;
use MyApp\UserBundle\Entity\Competanceaf;
use MyApp\UserBundle\Form\CompetanceForm;
use MyApp\UserBundle\Entity\Rcdmembre;
use MyApp\UserBundle\Entity\Recomandation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Tests\Model;

class CompetanceController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function ajoutAction(Request $request)
    {
        $Competance = new Competance();
        $Competanceaf = new Competanceaf();
        $em = $this->getDoctrine()->getManager();

        $idc = $request->get('idc');
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom = $user->getNom();
            $user_prenom = $user->getPrenom();
        }
        $us = $em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $cmp = $em->getRepository("MyAppUserBundle:Competance")->find((int)$idc);
        $c=$em->getRepository("MyAppUserBundle:Competanceaf")->findoneby(array(
            'membre' => $userId,
            'competance' =>$request->get('idc')));
        if($c==null){
        $Competanceaf->setMembre($us);
        $Competanceaf->setCompetance($cmp);
        $em->persist($Competanceaf);

        $em->flush(); $this->get('session')->getFlashBag()->add(
                'notice',
                'skill aded'
            );

        }
        if($c!=null){

        $em->flush(); $this->get('session')->getFlashBag()->add(
        'notice',
        'skill already affected'

            );
        }


        return $this->redirectToRoute('security_show_profile');

    }

    public function ajoutCmpAction(Request $request)
    {
        $Competance=new Competance();

        if($request->isMethod('POST')) {
            $em=$this->getDoctrine()->getManager();
            $cm=$em->getRepository('MyAppUserBundle:Competance')->findOneBynomCompetance($request->get('cp'));
            if($cm==null){
            $Competance->setNomCompetance($request->get('cp'));
            $em->persist($Competance);
            $em->flush();
                $em->flush(); $this->get('session')->getFlashBag()->add(
                    'notice',
                    'skill aded affected');
            }



        }




        $Competanceaf = new Competanceaf();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom = $user->getNom();
            $user_prenom = $user->getPrenom();
        }
        $us = $em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $cmp = $em->getRepository("MyAppUserBundle:Competance")->findBy(array('nomCompetance'=>$request->get('cp')));
        $c=$em->getRepository("MyAppUserBundle:Competanceaf")->findoneby(array(
            'membre' => $userId,
            'competance' =>$cmp[0]));
        if($c==null){
            $Competanceaf->setMembre($us);
            $Competanceaf->setCompetance($cmp[0]);
            $em->persist($Competanceaf);
            $em->flush();
        }
        if($c!=null){

            $em->flush(); $this->get('session')->getFlashBag()->add(
                'notice',
                'skill already affected or already exist '

            );
        }

        return $this->redirectToRoute('security_show_profile');



    }
    public function afficheAction(Request $request){
        $Competance = new Competance();

        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom = $user->getNom();
            $user_prenom = $user->getPrenom();

        }

        $query =$em->createQuery('SELECT c,cp from MyAppUserBundle:Competance c, MyAppUserBundle:Competanceaf cp where
 c.id=cp.competance and membre =:id');
        $query->setParameter('id', $userId.'%');
        $rs = $query->getResult();
        return $this->render("MyAppUserBundle:Profile:show.html.twig", array('rs'=>$rs));


    }
    public function deleteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $idc = $request->get('idc');
        var_dump($idc);

        $Competanceaf=$em->getRepository('MyAppUserBundle:Competanceaf')->findBy(array('competance'=>$request->get('idc')));

        $em->remove($Competanceaf[0]);
        $em->flush();
        $em->flush(); $this->get('session')->getFlashBag()->add(
        'notice',
        'skill deleted ');
        return $this->redirectToRoute('security_show_profile');

    }
    public function rcdAction(Request $request,$id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom=$user->getNom();
            $user_prenom=$user->getPrenom();
        }

        $Recomandation=new Recomandation();
        $idc = $request->get('idc');
        $em = $this->getDoctrine()->getManager();
        $rcd=$em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $mrec=$em->getRepository("MyAppUserBundle:User")->find($id);


        $c=$em->getRepository("MyAppUserBundle:Competanceaf")->findoneby(array(
        'membre' => $mrec,
        'competance' =>$request->get('idc')
    ));
      //  $mb=$em->getRepository("MyAppUserBundle:User")->findOneById($id);
        $Recomandation->setMembre($user);
        $Recomandation->setMembrec($mrec);
        $Recomandation->setCompetanceaf($c);
        /*var_dump($userId);
        var_dump($id);
        var_dump($c);*/


        $em->persist($Recomandation);
        $em->flush();
        $em->flush(); $this->get('session')->getFlashBag()->add(
        'notice',
        'recommandation aded ');
        $query =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:User a
                                       WHERE a.id=:id');

        $query->setParameter('id', $id.'%');


        $users = $query->getResult();

        $query2 =$em->createQuery('SELECT c.nomCompetance, c.id FROM 
                                       MyAppUserBundle:Competanceaf cp
                                       INNER join 
                                       cp.competance c
                                       where cp.membre= :utilisateur
                                       ')->setParameter('utilisateur', $users);

        $rs = $query2->getResult();
        $query3 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur  and a.membre!=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd = $query3->getResult();
        $query4 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur and a.membre=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd1 = $query4->getResult();
        $em = $this->getDoctrine()->getManager();
        $uc = $this->getUser();
        $ur = $users;
        $all=0;
        $all = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membre'=>$uc,'membrec'=>$ur));
        if($all) {
            for ($i = 0; $i < sizeof($all); $i++) {
                $cmpname[$i] = $all[$i]->getCompetanceaf()->getCompetance()->getNomCompetance();

            }
        }
        else{
            $cmpname='';
        }
        function array_value_recursive($key, array $arr){
            $val = array();
            array_walk_recursive($arr, function($v, $k) use($key, &$val){
                if($k == $key) array_push($val, $v);
            });
            return count($val) > 1 ? $val : array_pop($val);
        }
        $connection=$em->getConnection();


        $statement10 = $connection->prepare("SELECT P2.id AS id, P3.id AS MutualFriend 
FROM membre_contact AS F1 
JOIN membre_contact AS F2 ON F2.membre_id <> F1.membre_id 
AND F2.membreami_id = F1.membreami_id 
JOIN user AS P1 ON P1.ID = F1.membre_id 
JOIN user AS P2 ON P2.ID = F2.membre_id 
JOIN user AS P3 ON P3.ID = F2.membreami_id 
WHERE P1.id=:id
ORDER BY F1.membre_id, F2.membre_id
");
        $statement10->bindValue('id', $user);
        $statement10->execute();
        $results10 = $statement10->fetchAll();

        $amiCommun=array();

        for($i=0; $i< sizeof(array_value_recursive('id', $results10));$i++) {
            $cle = array_value_recursive('id', $results10[$i]);

            if (array_key_exists($cle, $amiCommun)) {
                array_push($amiCommun[$cle], array_value_recursive('MutualFriend', $results10[$i]));
            } else {
                $amiCommun[$cle] = array(array_value_recursive('MutualFriend', $results10[$i]));
            }
        }

        $x=$em->getRepository('MyAppUserBundle:Competanceaf')->findBy(array('membre'=>$user));
        $y = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membrec'=>$user));
        $X='';
        for($i=0;$i<sizeof($x);$i++){
            $r=0;
            for($j=0;$j<sizeof($y);$j++){

                if($y[$j]->getCompetanceaf()->getId()==$x[$i]->getId()){
                    $r++;
                }
            }
            $X[$i]=$r;
        }



        $em = $this->getDoctrine()->getManager();
        $query7 = $em->createQuery(
            'SELECT c.nom,c.prenom,c.imgurl FROM 
                                       MyAppUserBundle:MembreContact cp
                                       INNER join 
                                       cp.membre c
                                       where cp.membreami= :utilisateur')->setParameter('utilisateur', $user);
        $mb = $query7->getResult();

        $ff=$em->getRepository("MyAppUserBundle:MembreContact")->findBy(array('membre'=>$userId,'membreami'=>$user));

        if($ff!=0){
            $s="following";
            $s1="delete";
        }
        else{
            $s="follow";
            $s1="you are not following";
        }


        return $this->render("MyAppUserBundle:Recherche:layoutrecherche.html.twig", array('users'=>$users,'rs' => $rs,'rd' => $rd,'rd1' => $rd1,'rx'=>$cmpname
        ,'x' => $x,'X' => $X,'am'=>$amiCommun,'mb'=>$mb,'s'=>$s,'s1'=>$s1
        ));

    }
    public function drcdAction(Request $request,$id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom=$user->getNom();
            $user_prenom=$user->getPrenom();
        }
        function array_value_recursive($key, array $arr){
            $val = array();
            array_walk_recursive($arr, function($v, $k) use($key, &$val){
                if($k == $key) array_push($val, $v);
            });
            return count($val) > 1 ? $val : array_pop($val);
        }


        $em = $this->getDoctrine()->getManager();
        $rcd=$em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $idc = $request->get('idc');
        $cpid=$em->getRepository('MyAppUserBundle:Competance')->findOneBynomCompetance($request->get('idc'));
        var_dump($cpid);
        $Competanceaf=$em->getRepository('MyAppUserBundle:Competanceaf')->findBy(array(
            'competance'=> $cpid,
            'membre' => $id)

        );



        $c=$em->getRepository("MyAppUserBundle:Recomandation")->findBy(array(
            'membre' => $rcd,
            'competanceaf' =>$Competanceaf,
            'membrec' => $id


        ));


        $em->remove($c[0]);
        $em->flush();
        $em->flush(); $this->get('session')->getFlashBag()->add(
        'notice',
        'recommandation deleted ');


        $query =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:User a
                                       WHERE a.id=:id');

        $query->setParameter('id', $id.'%');


        $users = $query->getResult();

        $query2 =$em->createQuery('SELECT c.nomCompetance, c.id FROM 
                                       MyAppUserBundle:Competanceaf cp
                                       INNER join 
                                       cp.competance c
                                       where cp.membre= :utilisateur
                                       ')->setParameter('utilisateur', $users);

        $rs = $query2->getResult();
        $query3 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur  and a.membre!=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd = $query3->getResult();
        $query4 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur and a.membre=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd1 = $query4->getResult();


        $em = $this->getDoctrine()->getManager();
        $uc = $this->getUser();
        $ur = $users;
        $all = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membre'=>$uc,'membrec'=>$ur));
        $cmpname="";
        for($i=0;$i<sizeof($all);$i++)
        {
            $cmpname[$i] = $all[$i]->getCompetanceaf()->getCompetance()->getNomCompetance();
        }
        $connection=$em->getConnection();


        $statement10 = $connection->prepare("SELECT P2.id AS id, P3.id AS MutualFriend 
FROM membre_contact AS F1 
JOIN membre_contact AS F2 ON F2.membre_id <> F1.membre_id 
AND F2.membreami_id = F1.membreami_id 
JOIN user AS P1 ON P1.ID = F1.membre_id 
JOIN user AS P2 ON P2.ID = F2.membre_id 
JOIN user AS P3 ON P3.ID = F2.membreami_id 
WHERE P1.id=:id
ORDER BY F1.membre_id, F2.membre_id
");
        $statement10->bindValue('id', $user);
        $statement10->execute();
        $results10 = $statement10->fetchAll();

        $amiCommun=array();

        for($i=0; $i< sizeof(array_value_recursive('id', $results10));$i++) {
            $cle = array_value_recursive('id', $results10[$i]);

            if (array_key_exists($cle, $amiCommun)) {
                array_push($amiCommun[$cle], array_value_recursive('MutualFriend', $results10[$i]));
            } else {
                $amiCommun[$cle] = array(array_value_recursive('MutualFriend', $results10[$i]));
            }
        }

        $x=$em->getRepository('MyAppUserBundle:Competanceaf')->findBy(array('membre'=>$user));
        $y = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membrec'=>$user));
        $X='';
        for($i=0;$i<sizeof($x);$i++){
            $r=0;
            for($j=0;$j<sizeof($y);$j++){

                if($y[$j]->getCompetanceaf()->getId()==$x[$i]->getId()){
                    $r++;
                }
            }
            $X[$i]=$r;
        }



        $em = $this->getDoctrine()->getManager();
        $query7 = $em->createQuery(
            'SELECT c.nom,c.prenom,c.imgurl FROM 
                                       MyAppUserBundle:MembreContact cp
                                       INNER join 
                                       cp.membre c
                                       where cp.membreami= :utilisateur')->setParameter('utilisateur', $user);
        $mb = $query7->getResult();
        $ff=$em->getRepository("MyAppUserBundle:MembreContact")->findBy(array('membre'=>$userId,'membreami'=>$user));

        if($ff!=0){
            $s="following";
            $s1="delete";
        }
        else{
            $s="follow";
            $s1="you are not following";
        }



        return $this->render("MyAppUserBundle:Recherche:layoutrecherche.html.twig", array('users'=>$users,'rs' => $rs,'rd' => $rd,'rd1' => $rd1,'rx' => $cmpname,
        'x' => $x,'X' => $X,'am'=>$amiCommun,'mb'=>$mb,'s'=>$s,'s1'=>$s1
            ));


    }
    public function prAction(Request $request,$id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom=$user->getNom();
            $user_prenom=$user->getPrenom();
        }

        $Rcdmembre=new Rcdmembre();
        $em = $this->getDoctrine()->getManager();
        $rcd=$em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $mrec=$em->getRepository("MyAppUserBundle:User")->find($id);
        $c = $request->get('c');
        if($c!=""){
        $Rcdmembre->setMembre($user);
        $Rcdmembre->setMembrer($mrec);
        $Rcdmembre->setContenu($c);

        $em->persist($Rcdmembre);
        $em->flush();
            $em->flush(); $this->get('session')->getFlashBag()->add(
                'notice',
                'Recomandation aded ');
        }
        function array_value_recursive($key, array $arr){
            $val = array();
            array_walk_recursive($arr, function($v, $k) use($key, &$val){
                if($k == $key) array_push($val, $v);
            });
            return count($val) > 1 ? $val : array_pop($val);
        }





        $query =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:User a
                                       WHERE a.id=:id');

        $query->setParameter('id', $id.'%');


        $users = $query->getResult();

        $query2 =$em->createQuery('SELECT c.nomCompetance, c.id FROM 
                                       MyAppUserBundle:Competanceaf cp
                                       INNER join 
                                       cp.competance c
                                       where cp.membre= :utilisateur
                                       ')->setParameter('utilisateur', $users);

        $rs = $query2->getResult();
        $query3 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur  and a.membre!=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
        ->setParameter('utilisateur1', $userId);

        $rd = $query3->getResult();
        $query4 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur and a.membre=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd1 = $query4->getResult();
        $emm = $this->getDoctrine()->getManager();
        $qb = $emm->createQueryBuilder();
        $emm = $this->getDoctrine()->getManager();
        $qb = $emm->createQueryBuilder();
        $em = $this->getDoctrine()->getManager();
        $uc = $this->getUser();
        $ur = $users;
        $all = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membre'=>$uc,'membrec'=>$ur));
        $cmpname="";
        for($i=0;$i<sizeof($all);$i++)
        {
            $cmpname[$i] = $all[$i]->getCompetanceaf()->getCompetance()->getNomCompetance();
        }
        $connection=$em->getConnection();


        $statement10 = $connection->prepare("SELECT P2.id AS id, P3.id AS MutualFriend 
FROM membre_contact AS F1 
JOIN membre_contact AS F2 ON F2.membre_id <> F1.membre_id 
AND F2.membreami_id = F1.membreami_id 
JOIN user AS P1 ON P1.ID = F1.membre_id 
JOIN user AS P2 ON P2.ID = F2.membre_id 
JOIN user AS P3 ON P3.ID = F2.membreami_id 
WHERE P1.id=:id
ORDER BY F1.membre_id, F2.membre_id
");
        $statement10->bindValue('id', $user);
        $statement10->execute();
        $results10 = $statement10->fetchAll();

        $amiCommun=array();

        for($i=0; $i< sizeof(array_value_recursive('id', $results10));$i++) {
            $cle = array_value_recursive('id', $results10[$i]);

            if (array_key_exists($cle, $amiCommun)) {
                array_push($amiCommun[$cle], array_value_recursive('MutualFriend', $results10[$i]));
            } else {
                $amiCommun[$cle] = array(array_value_recursive('MutualFriend', $results10[$i]));
            }
        }

        $x=$em->getRepository('MyAppUserBundle:Competanceaf')->findBy(array('membre'=>$user));
        $y = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membrec'=>$user));
        $X='';
        for($i=0;$i<sizeof($x);$i++){
            $r=0;
            for($j=0;$j<sizeof($y);$j++){

                if($y[$j]->getCompetanceaf()->getId()==$x[$i]->getId()){
                    $r++;
                }
            }
            $X[$i]=$r;
        }



        $em = $this->getDoctrine()->getManager();
        $query7 = $em->createQuery(
            'SELECT c.nom,c.prenom,c.imgurl FROM 
                                       MyAppUserBundle:MembreContact cp
                                       INNER join 
                                       cp.membre c
                                       where cp.membreami= :utilisateur')->setParameter('utilisateur', $user);
        $mb = $query7->getResult();



        $ff=$em->getRepository("MyAppUserBundle:MembreContact")->findBy(array('membre'=>$userId,'membreami'=>$user));

        var_dump($ff);
        if($ff!=0){
            $s="following";
            $s1="delete";
        }
        else{
            $s="follow";
            $s1="you are not following";
        }

        return $this->render("MyAppUserBundle:Recherche:layoutrecherche.html.twig", array('users'=>$users,'rs' => $rs,'rd' => $rd,'rd1' => $rd1,'rx'=>$cmpname
        ,'x' => $x,'X' => $X,'am'=>$amiCommun,'mb'=>$mb,'s'=>$s,'s1'=>$s1
        ));
    }
    public function drAction(Request $request,$id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();
            $user_nom=$user->getNom();
            $user_prenom=$user->getPrenom();
        }
if($request->get('idc')!=null){
        $Rcdmembre=new Rcdmembre();
        $em = $this->getDoctrine()->getManager();
        $Rcdmembre=$em->getRepository('MyAppUserBundle:Rcdmembre')->findOneById($request->get('idc'));
        $em->remove($Rcdmembre);
        $em->flush();
    $em->flush(); $this->get('session')->getFlashBag()->add(
        'notice',
        'rcomandation deleted ');
}
        function array_value_recursive($key, array $arr){
            $val = array();
            array_walk_recursive($arr, function($v, $k) use($key, &$val){
                if($k == $key) array_push($val, $v);
            });
            return count($val) > 1 ? $val : array_pop($val);
        }



        $em = $this->getDoctrine()->getManager();


        $query =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:User a
                                       WHERE a.id=:id');

        $query->setParameter('id', $id.'%');


        $users = $query->getResult();

        $query2 =$em->createQuery('SELECT c.nomCompetance, c.id FROM 
                                       MyAppUserBundle:Competanceaf cp
                                       INNER join 
                                       cp.competance c
                                       where cp.membre= :utilisateur
                                       ')->setParameter('utilisateur', $users);

        $rs = $query2->getResult();
        $query3 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur  and a.membre!=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd = $query3->getResult();
        $query4 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur and a.membre=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd1 = $query4->getResult();
        $emm = $this->getDoctrine()->getManager();
        $qb = $emm->createQueryBuilder();
        $em = $this->getDoctrine()->getManager();
        $uc = $this->getUser();
        $ur = $users;
        $all = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membre'=>$uc,'membrec'=>$ur));
        $cmpname="";
        for($i=0;$i<sizeof($all);$i++)
        {
            $cmpname[$i] = $all[$i]->getCompetanceaf()->getCompetance()->getNomCompetance();
        }

        $connection=$em->getConnection();


        $statement10 = $connection->prepare("SELECT P2.id AS id, P3.id AS MutualFriend 
FROM membre_contact AS F1 
JOIN membre_contact AS F2 ON F2.membre_id <> F1.membre_id 
AND F2.membreami_id = F1.membreami_id 
JOIN user AS P1 ON P1.ID = F1.membre_id 
JOIN user AS P2 ON P2.ID = F2.membre_id 
JOIN user AS P3 ON P3.ID = F2.membreami_id 
WHERE P1.id=:id
ORDER BY F1.membre_id, F2.membre_id
");
        $statement10->bindValue('id', $user);
        $statement10->execute();
        $results10 = $statement10->fetchAll();

        $amiCommun=array();

        for($i=0; $i< sizeof(array_value_recursive('id', $results10));$i++) {
            $cle = array_value_recursive('id', $results10[$i]);

            if (array_key_exists($cle, $amiCommun)) {
                array_push($amiCommun[$cle], array_value_recursive('MutualFriend', $results10[$i]));
            } else {
                $amiCommun[$cle] = array(array_value_recursive('MutualFriend', $results10[$i]));
            }
        }

        $x=$em->getRepository('MyAppUserBundle:Competanceaf')->findBy(array('membre'=>$user));
        $y = $em->getRepository('MyAppUserBundle:Recomandation')->findBy(array('membrec'=>$user));
        $X='';
        for($i=0;$i<sizeof($x);$i++){
            $r=0;
            for($j=0;$j<sizeof($y);$j++){

                if($y[$j]->getCompetanceaf()->getId()==$x[$i]->getId()){
                    $r++;
                }
            }
            $X[$i]=$r;
        }



        $em = $this->getDoctrine()->getManager();
        $query7 = $em->createQuery(
            'SELECT c.nom,c.prenom,c.imgurl FROM 
                                       MyAppUserBundle:MembreContact cp
                                       INNER join 
                                       cp.membre c
                                       where cp.membreami= :utilisateur')->setParameter('utilisateur', $user);
        $mb = $query7->getResult();


        $ff=$em->getRepository("MyAppUserBundle:MembreContact")->findBy(array('membre'=>$userId,'membreami'=>$user));

        var_dump($ff);
        if($ff!=0){
            $s="following";
            $s1="delete";
        }
        else{
            $s="follow";
            $s1="you are not following";
        }

        return $this->render("MyAppUserBundle:Recherche:layoutrecherche.html.twig", array('users'=>$users,'rs' => $rs,'rd' => $rd,'rd1' => $rd1,'rx'=>$cmpname
        ,'x' => $x,'X' => $X,'am'=>$amiCommun,'mb'=>$mb,'s'=>$s,'s1'=>$s1
        ));
    }

}
