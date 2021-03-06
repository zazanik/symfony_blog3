<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{

    public function getPosts($limit = 10)
    {
        $query = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }

    /**
     * Get post with limit
     *
     * @param int $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getAllPosts($currentPage = 1, $limit = 10)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     * @param $dql
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function paginate($dql, $page = 1, $limit = 10)
    {
        if ($page === null) {
            $page = 1;
        }
        $paginator = new Paginator($dql, $fetchJoinCollection = true);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);
        return $paginator;
    }

}
