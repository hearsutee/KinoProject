<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FilmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FilmRepository extends EntityRepository
{

    public function search($word)
    {
        $reqFilm = $this->_em
            ->createQueryBuilder()
            ->select('f')
            ->from(' TroiswaPublicBundle:Film', 'f')
            ->where('f.titre LIKE :word')
            ->setParameter('word', '%' . $word . '%')
            ->getQuery()
            ->getScalarResult();

        return $reqFilm;

//        $reqActor = $this->_em
//            ->createQueryBuilder()
//            ->select('a.nom')
//            ->from(' TroiswaPublicBundle:Actor', 'a')
//            ->where('a.nom', 'LIKE', "%$search%")
//            ->getResult();
//
//        $reqDirector = $this->_em
//            ->createQueryBuilder()
//            ->select('d.nom')
//            ->from(' TroiswaPublicBundle:Director', 'd')
//            ->where('d.nom', 'LIKE', "%$search%")
//            ->getResult();

    }

    public function findActiveFilms()
    {
        return $this->_em
            ->createQueryBuilder()
            ->select('f')
            ->from(' TroiswaPublicBundle:Film', 'f')
            ->where('f.active=1')
            ->getQuery()
            ->getResult();
    }

    public function findByDescFilms()
    {
        return $this->getEntityManager()->createQuery('SELECT f FROM TroiswaPublicBundle:Film f ORDER BY f.dateCreation DESC')
            ->getResult();
    }

    public function findFilmAndComments($id)
    {
        return $this->_em
            ->createQueryBuilder()
            ->select('f, c')
            ->from(' TroiswaPublicBundle:Film', 'f')
            ->leftJoin('f.comments', 'c')
            ->where('f.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function findFandCprochainememt()
    {
        $now = new \DateTime( 'now' );

        return $this->_em
            ->createQueryBuilder()
            ->select('f, c')
            ->from(' TroiswaPublicBundle:Film', 'f')
            ->leftJoin('f.comments', 'c')
            ->where('f.dateCreation > :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();
    }

    public function findFandCaffiche()
    {
        $now = new \DateTime( 'now' );

        $interval = 35;
        $compare = date('Y-m-d H:i:s', strtotime('-' . $interval . ' day'));

        return $this->_em
            ->createQueryBuilder()
            ->select('f, c')
            ->from(' TroiswaPublicBundle:Film', 'f')
            ->leftJoin('f.comments', 'c')
            ->where('f.dateCreation < :now')
            ->andWhere('f.dateCreation >= :compare')
            ->setParameters(array( 'now' => $now, 'compare' => $compare ))
            ->getQuery()
            ->getResult();

    }

    public function findFandCarchive()
    {
        $now = new \DateTime( 'now' );
        $interval = 35;

        $compare = date('Y-m-d H:i:s', strtotime('-' . $interval . ' day'));

        return $this->_em
            ->createQueryBuilder()
            ->select('f, c')
            ->from(' TroiswaPublicBundle:Film', 'f')
            ->leftJoin('f.comments', 'c')
            ->where('f.dateCreation < :now')
            ->andWhere('f.dateCreation <= :compare')
            ->setParameters(array( 'now' => $now, 'compare' => $compare ))
            ->getQuery()
            ->getResult();
    }

}
