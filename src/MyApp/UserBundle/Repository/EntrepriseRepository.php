<?php
namespace MyApp\UserBundle\Repository;

/**
 * Created by PhpStorm.
 * User: Sara
 * Date: 29/11/2016
 * Time: 19:32
 */

use Doctrine\ORM\EntityRepository;

class EntrepriseRepository extends  EntityRepository
{
    public function  findlike($ke)
    {
        $ke="%".$ke."%";

        $query=$this->getEntityManager()
        ->createQuery("SELECT e FROM MyAppUserBundle:Entreprise e  WHERE e.nomentreprise LIKE ?1 OR e.domaine LIKE ?2 OR e.adresse  LIKE ?3 ");

        $query->setParameters(array(1=>$ke,2=>$ke,3=>$ke));
    return $query->getResult();
    }

}