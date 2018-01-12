<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competanceaf
 *
 * @ORM\Table(name="competanceaf", indexes={@ORM\Index(name="competance_id", columns={"competance_id"}), @ORM\Index(name="membre_id", columns={"membre_id"})})
 * @ORM\Entity
 */
class Competanceaf
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="membre_id", referencedColumnName="id")
     * })
     */
    private $membre;

    /**
     * @var \Competance
     *
     * @ORM\ManyToOne(targetEntity="Competance")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="competance_id", referencedColumnName="id")
     * })
     */
    private $competance;

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
     * @return \User
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param \User $membre
     */
    public function setMembre($membre)
    {
        $this->membre = $membre;
    }

    /**
     * @return \Competance
     */
    public function getCompetance()
    {
        return $this->competance;
    }

    /**
     * @param \Competance $competance
     */
    public function setCompetance($competance)
    {
        $this->competance = $competance;
    }



}

