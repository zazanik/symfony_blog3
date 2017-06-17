<?php
namespace AppBundle\Services\Post;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Post;

class PostHelper{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getLastPosts($limit = 5)
    {
        $lastPosts = $this->em->getRepository(Post::class)->getPosts($limit);
        return $lastPosts;
    }



}