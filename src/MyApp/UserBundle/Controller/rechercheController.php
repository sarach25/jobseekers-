<?php

namespace MyApp\UserBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class rechercheController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function rechercherByNomPrenomAction(Request $request)
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

        $motcle=$request->get('motcle');

        $query =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:User a
                                       WHERE a.nom LIKE :motcle OR a.prenom like :motcle
        and a.nom NOT LIKE :x AND a.prenom NOT LIKE :y'
        );
        $query->setParameter('x', $user_nom.'%');
        $query->setParameter('y', $user_prenom.'%');
        $query->setParameter('motcle', $motcle.'%');
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
        $query3 =$em->createQuery('SELECT a FROM 
                                       MyAppUserBundle:Rcdmembre a
                                       WHERE a.membrer=:utilisateur and a.membre=:utilisateur1
                                       ')->setParameter('utilisateur', $users)
            ->setParameter('utilisateur1', $userId);

        $rd1 = $query3->getResult();

      /*  $emm = $this->getDoctrine()->getManager();
        $qb = $emm->createQueryBuilder();
        $rx = $qb
            ->addselect('c.nomCompetance,c.id')
            //->addselect('r.id')
            ->from('MyAppUserBundle:Competanceaf ', 'cp')

            ->Join('cp.competance', 'c')
            ->where('cp.membre = :utilisateur')

            ->setParameter('utilisateur', $users)

            ->getQuery()
            ->getResult();*/

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

        $sender=$em->getRepository("MyAppUserBundle:User")->findOneById($userId);
        $ff=$em->getRepository("MyAppUserBundle:MembreContact")->findOneBy(array('membre'=>$userId,'membreami'=>$user));

        var_dump($ff);
        if($ff!=0){
            $s="following";
            $s1="delete";
        }
        else{
            $s="follow";
            $s1="you are not following";
        }






        return $this->render("MyAppUserBundle:Recherche:layoutrecherche.html.twig", array('users'=>$users,'rs' => $rs,'rd' => $rd,'rd1' => $rd1,'rx' => $cmpname
        ,'x' => $x,'X' => $X,'am'=>$amiCommun,'mb'=>$mb,'s'=>$s,'s1'=>$s1));
    }
}
