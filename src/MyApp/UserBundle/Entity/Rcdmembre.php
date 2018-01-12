<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rcdmembre
 *
 * @ORM\Table(name="rcdmembre", indexes={@ORM\Index(name="membre_id", columns={"membre_id"}), @ORM\Index(name="membreR_id", columns={"membreR_id"})})
 * @ORM\Entity
 */
class Rcdmembre
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
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="membreR_id", referencedColumnName="id")
     * })
     */
    private $membrer;

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
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return \User
     */
    public function getMembrer()
    {
        return $this->membrer;
    }

    /**
     * @param \User $membrer
     */
    public function setMembrer($membrer)
    {
        $this->membrer = $membrer;
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


}

