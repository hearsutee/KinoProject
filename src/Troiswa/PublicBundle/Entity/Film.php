<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Film
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\FilmRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Film
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean" )
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=4000)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToMany(targetEntity="Troiswa\PublicBundle\Entity\Actor", mappedBy="films")
     */
    private $acteurs;

    /**
     * @ORM\OneToMany(targetEntity="Troiswa\PublicBundle\Entity\Comment", mappedBy="film", cascade={"remove"})
     * @ORM\JoinColumn(name="comments")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\PublicBundle\Entity\Category", inversedBy="films")
     * @ORM\JoinColumn(name="categories")
     */
    private $categories;

    /**
     * @ORM\OneToOne(targetEntity="Troiswa\PublicBundle\Entity\Image", inversedBy="film", cascade={"persist","remove"})
     *
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Troiswa\PublicBundle\Entity\Director", mappedBy="films")
     * @ORM\JoinColumn(name="films")
     */
    private $realisateurs;

    /**
     * @ORM\OneToMany(targetEntity="Troiswa\PublicBundle\Entity\FilmTag", mappedBy="film", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="films")
     */
    private $tags;

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
     * Set titre
     *
     * @param  string $titre
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param  string $contenu
     * @return Film
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateCreation
     *
     * @param  \DateTime $dateCreation
     * @return Film
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set active
     *
     * @param  boolean $active
     * @return Film
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->acteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add acteurs
     *
     * @param  \Troiswa\PublicBundle\Entity\Actor $acteurs
     * @return Film
     */
    public function addActeur(\Troiswa\PublicBundle\Entity\Actor $acteurs)
    {
        $this->acteurs[] = $acteurs;

        $acteurs->addFilm($this);

        return $this;
    }

    /**
     * Remove acteurs
     *
     * @param \Troiswa\PublicBundle\Entity\Actor $acteurs
     */
    public function removeActeur(\Troiswa\PublicBundle\Entity\Actor $acteurs)
    {
        $this->acteurs->removeElement($acteurs);
        $acteurs->remove($this);
    }

    /**
     * Get acteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActeurs()
    {
        return $this->acteurs;
    }

    /**
     * Set categories
     *
     * @param  \Troiswa\PublicBundle\Entity\Category $categories
     * @return Film
     */
    public function setCategories(\Troiswa\PublicBundle\Entity\Category $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \Troiswa\PublicBundle\Entity\Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add comments
     *
     * @param  \Troiswa\PublicBundle\Entity\Comment $comments
     * @return Film
     */
    public function addComment(\Troiswa\PublicBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Troiswa\PublicBundle\Entity\Comment $comments
     */
    public function removeComment(\Troiswa\PublicBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add realisateurs
     *
     * @param  \Troiswa\PublicBundle\Entity\Director $realisateurs
     * @return Film
     */
    public function addRealisateur(\Troiswa\PublicBundle\Entity\Director $realisateurs)
    {
        $this->realisateurs[] = $realisateurs;

        return $this;
    }

    /**
     * Remove realisateurs
     *
     * @param \Troiswa\PublicBundle\Entity\Director $realisateurs
     */
    public function removeRealisateur(\Troiswa\PublicBundle\Entity\Director $realisateurs)
    {
        $this->realisateurs->removeElement($realisateurs);
    }

    /**
     * Get realisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRealisateurs()
    {
        return $this->realisateurs;
    }

    /**
     * Set image
     *
     * @param  \Troiswa\PublicBundle\Entity\Image $image
     * @return Film
     */
    public function setImage(\Troiswa\PublicBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        $image->setFilm($this);

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

//    /**
//     * @ORM\PrePersist()
//     * @ORM\PreUpdate()
//     */
//    public function folderImage()
//    {
//        if ($this->image)
//        {
//            $this->image->setFolder(mb_strtolower(get_class($this)));
//        }
//    }

    public function __toString()
    {
        return $this->titre;
    }

    /**
     * Add tags
     *
     * @param  \Troiswa\PublicBundle\Entity\FilmTag $tags
     * @return Film
     */
    public function addTag(\Troiswa\PublicBundle\Entity\FilmTag $tags)
    {
        $this->tags[] = $tags;
        $tags->setFilm($this);

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Troiswa\PublicBundle\Entity\FilmTag $tags
     */
    public function removeTag(\Troiswa\PublicBundle\Entity\FilmTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

}
