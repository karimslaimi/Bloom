<?php

namespace DoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="DoraBundle\Repository\RatingRepository")
 */
class Rating
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

     * @ORM\Column(name="comment",type="string")
     */
    private $comment;

    /**
     * @ORM\Column(name="rate",type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(name="date",type="datetime")
     */
    private $date;

    /**
     *  @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     htmlPattern = "^[a-zA-Z ]+$"
     * )
     * @ORM\Column(name="client",type="string")
     */
    private $client;


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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rate
     */
    public function setRating($rate)
    {
        $this->rating = $rate;
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
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }





}

