<?php
namespace AppBundle\Services\Post;

use AppBundle\Entity\Category;
use AppBundle\Services\PaginateManager;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class PostHelper{

    public function __construct(EntityManager $em,
                                PaginateManager $pm,
                                $limit
    ){
        $this->em = $em;
        $this->pm = $pm;
        $this->limit = $limit;
    }

    public function getLastPosts($limit = 10)
    {
        $posts = $this->em->getRepository(Post::class)->getLastPosts($limit);
        return $posts;
    }

    public function getPaginatePosts(Request $request)
    {
        $thisPage = $request->query->get('page');

        $paginationPosts = $this->em->getRepository(Post::class)->getAllPosts($thisPage, $this->limit);
        $pagesParameters = $this->pm->paginate($thisPage, $paginationPosts);

        $result = new \StdClass();

        $result->paginationPosts = $paginationPosts;
        $result->pagesParameters = $pagesParameters;

        return $result;
    }

    /**
     * @param array $category
     * @param int $limit
     * @return mixed
     */
    public function getCategoryPosts($category, $limit = 5){

        if (!empty($category) ){
            return $this->em->getRepository(Post::class)->getSameCategoryPosts($category, $limit);
        } else {
            return $this->getLastPosts(3);
        }

    }

}