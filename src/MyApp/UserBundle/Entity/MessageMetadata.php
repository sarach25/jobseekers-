<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28/11/2016
 * Time: 21:53
 */

namespace MyApp\UserBundle\Entity;
use FOS\MessageBundle\Entity\MessageMetadata as BaseMessageMetadata;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MessageMetadata extends BaseMessageMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="MyApp\UserBundle\Entity\Message",
     *   inversedBy="metadata"
     * )
     * @var \FOS\MessageBundle\Model\MessageInterface
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $participant;
}