<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="ProduitBundle\Repository\ProduitRepository")
 */
class Produit
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=200, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nomproduit;


    /**
     * @var integer
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="prix", type="integer", nullable=true)
     */
    private $prix_prod;

    /**
     * @var integer
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="qte", type="integer", nullable=false)
     */
    private $qte;

    /**
     *
     * @ORM\ManyToOne(targetEntity="CategorieBundle\Entity\Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $id_categorie;


    public function getWebpath(){


        return null === $this->img_prod ? null : $this->getUploadDir.'/'.$this->img_prod;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../web/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->img_prod = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->img_prod = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $img_prod;

    /**
     * @return string
     */
    public function getNomproduit()
    {
        return $this->nomproduit;
    }

    /**
     * @param string $nomproduit
     */
    public function setNomproduit($nomproduit)
    {
        $this->nomproduit = $nomproduit;
    }

    /**
     * @return int
     */
    public function getPrixProd()
    {
        return $this->prix_prod;
    }

    /**
     * @param int $prix_prod
     */
    public function setPrixProd($prix_prod)
    {
        $this->prix_prod = $prix_prod;
    }

    /**
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }

    /**
     * @return mixed
     */
    public function getIdCategorie()
    {
        return $this->id_categorie;
    }

    /**
     * @param mixed $id_categorie
     */
    public function setIdCategorie($id_categorie)
    {
        $this->id_categorie = $id_categorie;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getImgProd()
    {
        return $this->img_prod;
    }

    /**
     * @param string $img_prod
     */
    public function setImgProd($img_prod)
    {
        $this->img_prod = $img_prod;
    }









}

