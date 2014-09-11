<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Actor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\ActorRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Actor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="biographie", type="string", length=4000)
     */
    private $biographie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="naissance", type="date")
     */
    private $naissance;

    /**
     * @ORM\OneToOne(targetEntity="Troiswa\PublicBundle\Entity\Image", inversedBy="actor", cascade={"persist","remove"})
     *
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Troiswa\PublicBundle\Entity\Film", inversedBy="acteurs")
     * @ORM\JoinColumn(name="films")
     */
    private $films;

    /**
     * @Gedmo\Slug(fields={"nom"}, updatable=true)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param  string $nom
     * @return actor
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set naissance
     *
     * @param  \DateTime $naissance
     * @return actor
     */
    public function setNaissance($naissance)
    {
        $this->naissance = $naissance;

        return $this;
    }

    /**
     * Get naissance
     *
     * @return \DateTime
     */
    public function getNaissance()
    {
        return $this->naissance;
    }

    /**
     * Set biographie
     *
     * @param  string $biographie
     * @return Actor
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set films
     *
     * @param  string $films
     * @return Actor
     */
    public function setFilms($films)
    {
        $this->films = $films;

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->films = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add films
     *
     * @param  \Troiswa\PublicBundle\Entity\Film $films
     * @return Actor
     */
    public function addFilm(\Troiswa\PublicBundle\Entity\Film $films)
    {
        $this->films[] = $films;

        return $this;
    }

    /**
     * Remove films
     *
     * @param \Troiswa\PublicBundle\Entity\Film $films
     */
    public function removeFilm(\Troiswa\PublicBundle\Entity\Film $films)
    {
        $this->films->removeElement($films);
    }

    /**
     * Get films
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * Set image
     *
     * @param  \Troiswa\PublicBundle\Entity\Image $image
     * @return Actor
     */
    public function setImage(\Troiswa\PublicBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        $image->setActor($this);

        return $this;
    }

    /**
     * Get image
     *
     * @return \Troiswa\PublicBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Actor
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
//==========temp n'attrap pas les modif lors de l'edit====================
//    /**
//     * @ORM\PrePersist()
//     * @ORM\PreUpdate()
//     */
//    public function folderImage()
//    {
//        if ($this->image)
//        {
//            $reflect = new \ReflectionClass($this);
//            $this->image->setFolder($reflect->getShortName());
//        }
//    }

    public function __toString()
    {
        return $this->nom;
    }
}
