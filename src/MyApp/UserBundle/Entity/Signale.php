<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signale
 *
 * @ORM\Table(name="signale", indexes={@ORM\Index(name="membre_id", columns={"membre_id"}), @ORM\Index(name="pub_id", columns={"publication_id"})})
 * @ORM\Entity
 */
class Signale
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
     * @ORM\Column(name="datesign", type="string", length=30, nullable=true)
     */
    private $datesign;

    /**
     * @var string
     *
     * @ORM\Column(name="raison", type="text", length=65535, nullable=true)
     */
    private $raison;

    /**
     * @var \Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="publication_id", referencedColumnName="ID")
     * })
     */
    private $publication;

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

