<?php

namespace DoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="DoraBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     htmlPattern = "^[a-zA-Z ]+$"
     * )
     * @ORM\Column(name="name",type="string")
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     htmlPattern = "^[a-zA-Z ]+$"
     * )
     * @ORM\Column(name="subject",type="string")
     */
    private $subject;

    /**
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     htmlPattern = "^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$"
     * )
     * @ORM\Column(name="email",type="string")
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @Assert\NotNull
     * @ORM\Column(name="message",type="string")
     */
    private $message;

    /**

     * @ORM\Column(name="date",type="datetime")
     */
    private $date;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }




}

