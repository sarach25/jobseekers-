<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recomandation
 *
 * @ORM\Table(name="recomandation", indexes={@ORM\Index(name="membre_id", columns={"membre_id"}), @ORM\Index(name="membreC_id", columns={"membreC_id"}), @ORM\Index(name="competanceAf_id", columns={"competanceAf_id"})})
 * @ORM\Entity
 */
class Recomandation
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
     * @var \Competanceaf
     *
     * @ORM\ManyToOne(targetEntity="Competanceaf")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="competanceAf_id", referencedColumnName="id")
     * })
     */
    private $competanceaf;

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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="membreC_id", referencedColumnName="id")
     * })
     */
    private $membrec;

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
     * @return \Competanceaf
     */
    public function getCompetanceaf()
    {
        return $this->competanceaf;
    }

    /**
     * @param \Competanceaf $competanceaf
     */
    public function setCompetanceaf($competanceaf)
    {
        $this->competanceaf = $competanceaf;
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
     * @return \User
     */
    public function getMembrec()
    {
        return $this->membrec;
    }

    /**
     * @param \User $membrec
     */
    public function setMembrec($membrec)
    {
        $this->membrec = $membrec;
    }



}

