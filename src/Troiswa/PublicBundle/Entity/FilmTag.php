<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilmTag
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 */
class FilmTag
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Troiswa\PublicBundle\Entity\Film",inversedBy="tags")
     */
    private $film;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Troiswa\PublicBundle\Entity\Tag")
     */
    private $tag;

    /**
     * @ORM\Column(name="poids", type="integer")
     *
     */
    private $poids;

    /**
     * Set poids
     *
     * @param  integer $poids
     * @return FilmTag
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return integer
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * Set film
     *
     * @param  \Troiswa\PublicBundle\Entity\Film $film
     * @return FilmTag
     */
    public function setFilm(\Troiswa\PublicBundle\Entity\Film $film)
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
     * Set tag
     *
     * @param  \Troiswa\PublicBundle\Entity\Tag $tag
     * @return FilmTag
     */
    public function setTag(\Troiswa\PublicBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \Troiswa\PublicBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
