<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\SeanceRepository")
 */
class Seance
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
     * @ORM\ManyToOne(targetEntity="Troiswa\PublicBundle\Entity\Film")
     */
    private $film;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Troiswa\PublicBundle\Entity\Cinema")
     */
    private $cinema;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_Seance", type="date")
     */
    private $dateSeance;

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
     * Set dateSeance
     *
     * @param  \DateTime $dateSeance
     * @return Seance
     */
    public function setDateSeance($dateSeance)
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    /**
     * Get dateSeance
     *
     * @return \DateTime
     */
    public function getDateSeance()
    {
        return $this->dateSeance;
    }

    /**
     * Set film
     *
     * @param  \Troiswa\PublicBundle\Entity\Film $film
     * @return Seance
     */
    public function setFilm(\Troiswa\PublicBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \Troiswa\PublicBundle\Entity\Film
     */
    public function getFilm()
    {
        return $this->film;
    }

    /**
     * Set cinema
     *
     * @param  \Troiswa\PublicBundle\Entity\Cinema $cinema
     * @return Seance
     */
    public function setCinema(\Troiswa\PublicBundle\Entity\Cinema $cinema = null)
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return \Troiswa\PublicBundle\Entity\Cinema
     */
    public function getCinema()
    {
        return $this->cinema;
    }
}
