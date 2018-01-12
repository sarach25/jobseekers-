<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembreContact
 *
 * @ORM\Table(name="membre_contact", indexes={@ORM\Index(name="idmembre", columns={"membre_id"}), @ORM\Index(name="idmembre_ami", columns={"membreami_id"})})
 * @ORM\Entity
 */
class MembreContact
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="membreami_id", referencedColumnName="id")
     * })
     */
    private $membreami;

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
     * @return \User
     */
    public function getMembreami()
    {
        return $this->membreami;
    }

    /**
     * @param \User $membreami
     */
    public function setMembreami($membreami)
    {
        $this->membreami = $membreami;
    }


}

