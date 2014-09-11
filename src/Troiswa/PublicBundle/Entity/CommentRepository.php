<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    public function findAllByFilm($id)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT c FROM TroiswaPublicBundle:Comment c WHERE c.film = :id ")
            ->setParameter('id', $id)
            ->getResult();

    }

    public function findRecents()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT c FROM TroiswaPublicBundle:Comment c   ")

            ->getResult();
    }
}
