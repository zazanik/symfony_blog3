<?php

namespace AppBundle\Services\Category;

use AppBundle\Entity\Category;
use AppBundle\Services\PaginateManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class CategoryHelper
{
    public function __construct(EntityManager $entityManager, PaginateManager $pm, $limit)
    {
        $this->em = $entityManager;
        $this->pm = $pm;
        $this->limit = $limit;
    }

    public function getPaginatePosts($thisPage, $id)
    {
        
        $paginationPosts = $this->em->getRepository(Category::class)->getPostsByCategory($id, $thisPage, $this->limit);
        $pagesParameters = $this->pm->paginate($thisPage, $paginationPosts);

        $result = new \StdClass();

        $result->paginationPosts = $paginationPosts;
        $result->pagesParameters = $pagesParameters;

        return $result;
    }



    public function getLastCategories($limit = 5){
        return $this->em->getRepository(Category::class)->getLastCategories($limit);
    }


}