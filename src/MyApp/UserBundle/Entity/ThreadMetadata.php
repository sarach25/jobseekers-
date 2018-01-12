<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28/11/2016
 * Time: 21:59
 */

namespace MyApp\UserBundle\Entity;
use FOS\MessageBundle\Entity\ThreadMetadata as BaseThreadMetadata;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ThreadMetadata  extends BaseThreadMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="MyApp\UserBundle\Entity\Thread",
     *   inversedBy="metadata"
     * )
     * @var \FOS\MessageBundle\Model\ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $participant;

}