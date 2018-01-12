<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OffreEmp
 *
 * @ORM\Table(name="offre_emp", indexes={@ORM\Index(name="FK_REFERENCE_10", columns={"MEMBRE_ID"})})
 * @ORM\Entity
 */
class OffreEmp
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
     * @ORM\Column(name="NOMENTREPRISE", type="string", length=254, nullable=true)
     */
    private $nomentreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="POSTE", type="string", length=254, nullable=true)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="DOMAINE", type="string", length=254, nullable=true)
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="CONTENU", type="string", length=254, nullable=true)
     */
    private $contenu;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MEMBRE_ID", referencedColumnName="id")
     * })
     */
    private $membre;


}

