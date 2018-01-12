<?php

namespace MyApp\UserBundle \Entity;

use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;

use Doctrine\ORM\Mapping as ORM;

/**

 * @ORM\Entity

 * @ORM\Table(name="user")

 */

class User extends BaseUser implements ParticipantInterface

{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var integer
     *
     * @ORM\Column(name="Admin_ID", type="integer", nullable=false)
     */
    private $adminId = '123456';

    /**
     * @var integer
     *
     * @ORM\Column(name="CIN", type="integer", nullable=true)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     *
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255,nullable=true)
     */
    private $states;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255,nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=50,nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=250,nullable=true)
     */
    private $imgurl='no-image-icon-md.png';

    /**
     * @var string
     *
     * @ORM\Column(name="typemembre", type="string", length=254, nullable=false)
     */
    private $typemembre = 'gratuit';

    /**
     * @var string
     *
     * @ORM\Column(name="etatmembre", type="string", length=254, nullable=false)
     */
    private $etatmembre = 'active';

    /**
     * @var string
     *
     * @ORM\Column(name="statutac", type="text", length=65535, nullable=true)
     */
    private $statutac;

    /**
     * @var string
     *
     * @ORM\Column(name="cursusac", type="text", length=65535, nullable=true)
     */
    private $cursusac;

    /**
     * @var string
     *
     * @ORM\Column(name="cursuspro", type="text", length=65535, nullable=true)
     */
    private $cursuspro;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="text", length=65535, nullable=true)
     */
    private $resume;


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
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * @param int $adminId
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    }

    /**
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param string $states
     */
    public function setStates($states)
    {
        $this->states = $states;
    }




    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }



    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getImgurl()
    {
        return $this->imgurl;
    }

    /**
     * @param string $imgurl
     */
    public function setImgurl($imgurl)
    {
        $this->imgurl = $imgurl;
    }

    /**
     * @return string
     */
    public function getTypemembre()
    {
        return $this->typemembre;
    }

    /**
     * @param string $typemembre
     */
    public function setTypemembre($typemembre)
    {
        $this->typemembre = $typemembre;
    }

    /**
     * @return string
     */
    public function getEtatmembre()
    {
        return $this->etatmembre;
    }

    /**
     * @param string $etatmembre
     */
    public function setEtatmembre($etatmembre)
    {
        $this->etatmembre = $etatmembre;
    }

    /**
     * @return string
     */
    public function getStatutac()
    {
        return $this->statutac;
    }

    /**
     * @param string $statutac
     */
    public function setStatutac($statutac)
    {
        $this->statutac = $statutac;
    }

    /**
     * @return string
     */
    public function getCursusac()
    {
        return $this->cursusac;
    }

    /**
     * @param string $cursusac
     */
    public function setCursusac($cursusac)
    {
        $this->cursusac = $cursusac;
    }

    /**
     * @return string
     */
    public function getCursuspro()
    {
        return $this->cursuspro;
    }

    /**
     * @param string $cursuspro
     */
    public function setCursuspro($cursuspro)
    {
        $this->cursuspro = $cursuspro;
    }

    /**
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param string $resume
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
    }
    public function __construct()
    {
        parent::__construct();
        $this->addRole("membre");

    }











}