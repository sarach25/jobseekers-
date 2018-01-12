<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signalmembre
 *
 * @ORM\Table(name="signalmembre", indexes={@ORM\Index(name="membre_id", columns={"membre_id"}), @ORM\Index(name="membresignale_id", columns={"membresignale_id"})})
 * @ORM\Entity
 */
class Signalmembre
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
     * @ORM\Column(name="date", type="string", length=10, nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="raison", type="text", length=65535, nullable=false)
     */
    private $raison;

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
     *   @ORM\JoinColumn(name="membresignale_id", referencedColumnName="id")
     * })
     */
    private $membresignale;


}

