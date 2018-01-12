<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="membre_id", columns={"membre_id"})})
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="DATE", type="string", length=254, nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="typepub", type="string", length=30, nullable=false)
     */
    private $typepub;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="etatpub", type="string", length=255, nullable=false)
     */
    private $etatpub;

    /**
     * @var string
     *
     * @ORM\Column(name="urlimg", type="string", length=200, nullable=false)
     */
    private $urlimg;

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

