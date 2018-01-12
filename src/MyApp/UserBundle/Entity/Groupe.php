<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe", indexes={@ORM\Index(name="membre_id", columns={"membre_id"})})
 * @ORM\Entity
 */
class Groupe
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
     * @ORM\Column(name="nomgroupe", type="string", length=50, nullable=false)
     */
    private $nomgroupe;

    /**
     * @var string
     *
     * @ORM\Column(name="contenugroupe", type="text", length=65535, nullable=false)
     */
    private $contenugroupe;

    /**
     * @var string
     *
     * @ORM\Column(name="imgroupe", type="blob", nullable=false)
     */
    private $imgroupe;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="membre_id", referencedColumnName="id")
     * })
     */
    private $membre;


}

