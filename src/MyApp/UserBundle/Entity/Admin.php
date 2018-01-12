<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_ADMIN", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="MAIL", type="string", length=254, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="PWD", type="string", length=254, nullable=true)
     */
    private $pwd;


}

