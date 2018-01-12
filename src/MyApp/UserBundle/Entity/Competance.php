<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competance
 *
 * @ORM\Table(name="competance")
 * @ORM\Entity
 */
class Competance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_competance", type="string", length=50, nullable=true)
     */
    private $nomCompetance;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNomCompetance()
    {
        return $this->nomCompetance;
    }

    /**
     * @param string $nomCompetance
     */
    public function setNomCompetance($nomCompetance)
    {
        $this->nomCompetance = $nomCompetance;
    }


}

