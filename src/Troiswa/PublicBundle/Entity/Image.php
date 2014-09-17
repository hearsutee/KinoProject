<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
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

    private $file;

    /**
     * @ORM\OneToOne(targetEntity="Troiswa\PublicBundle\Entity\Actor", mappedBy="image")
     */
    private $actor;

    /**
     * @ORM\OneToOne(targetEntity="Troiswa\PublicBundle\Entity\Film", mappedBy="image")
     */
    private $film;

    private $oldNom;

    private $folder;

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
     * @return Image
     */
    public function setNom($nom)
    {
        $ImageName = $this->removeAccent($nom);
        $ImageName = str_replace(' ', '_', $ImageName);
        $this->nom = $ImageName;

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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if (null !== $this->nom) {
            $this->oldNom = $this->nom;
            $this->nom = null;
        } else {
            $this->nom = '';
        }

        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {

        if (null === $this->file) {
            return false;
        }

        if (null !== $this->oldNom) {
            if (file_exists($this->getAbsoluteOldPath())) {
                unlink($this->getAbsoluteOldPath());
            }
        }

        $ext = '.' . pathinfo($this->nom, PATHINFO_EXTENSION); //on trouve l'extension.
        $base = basename($this->nom, $ext); //on enleve l'extension.


        $this->file->move($this->getUploadRootDir(), $this->nom);

        $imagine = new \Imagine\Gd\Imagine();

        $imagine->open($this->getAbsolutePath())
            ->thumbnail(new\Imagine\Image\Box( 400, 400 ))
            ->save($this->getUploadRootDir() . $base . $ext,
                array( 'quality' => 80 ));

        $imagine->open($this->getAbsolutePath())
            ->thumbnail(new\Imagine\Image\Box( 200, 200 ))
            ->save($this->getUploadRootDir() . $base . '-medium' . $ext,
                array( 'quality' => 80 ));

        $imagine->open($this->getAbsolutePath())
            ->thumbnail(new\Imagine\Image\Box( 100, 100 ))
            ->save($this->getUploadRootDir() . $base . '-small' . $ext,
                array( 'quality' => 80 ));
    }

    public function getAbsoluteOldPath()
    {
        if (null === $this->oldNom) {
            return false;
        } else {
            return $this->getUploadRootDir() . '/' . $this->oldNom;
        }
    }

    public function getUploadRootDir()
    {
        return getRootDir() . '/../../../../web/upload/' . $this->folder . '/'; //on est dans entity
    }

    public function getUploadDir()
    {
        return 'upload/' . $this->folder;
    }

    public function getWebPath($thumbmail = null)
    {
        if (null === $this->nom) {
            return null;
        } else {
            if ($thumbmail) {
                $AAAthumbnail = $this->nom . '-' . $thumbnail;
                if (file_exists($this->getUploadRootDir() . '/' . $AAAthumbnail)) {
                    $this->nom = $AAAthumbnail;
                }
            }
//            $nomSansAccent = utf8_decode($this->nom);
            return $this->getUploadDir() . '/' . $this->nom;

        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        if (null === $this->file) {
            return false;
        } else {
            $this->nom = $this->nom . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeFile()
    {
        $file = $this->getAbsolutePath();
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function getAbsolutePath()
    {
        if (null === $this->nom) {
            return null;
        } else {
            return $this->getUploadRootDir() . '/' . $this->nom;
        }
    }

    public function setOldNom($oldNom)
    {
        $this->oldNom = $oldNom;

        return $this;
    }

    public function getOldNom()
    {
        return $this->oldNom;
    }

    /**
     * Set actor
     *
     * @param  \Troiswa\PublicBundle\Entity\Actor $actor
     * @return Image
     */
    public function setActor(\Troiswa\PublicBundle\Entity\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \Troiswa\PublicBundle\Entity\Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Set film
     *
     * @param  \Troiswa\PublicBundle\Entity\Film $film
     * @return Image
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

    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    private function removeAccent($str, $encoding = 'utf-8')
    {
        // transformer les caractères accentués en entités HTML
        $str = htmlentities($str, ENT_NOQUOTES, $encoding);

        // remplacer les entités HTML pour avoir juste le premier caractères non accentués
        // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "Ã " => "a" ...
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);

        // Remplacer les ligatures tel que : Œ, Æ ...
        // Exemple "Å“" => "oe"
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        // Supprimer tout le reste
        $str = preg_replace('#&[^;]+;#', '', $str);

        return $str;
    }
}
