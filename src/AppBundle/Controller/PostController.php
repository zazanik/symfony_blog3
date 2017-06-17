<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\PostRepository;
use AppBundle\Services\PaginateManager;

class PostController extends Controller
{

    /**
     * @Route("/", name="post_list")
     * @Template()
     */
    public function listAction(Request $request)
    {

        $thisPage = $request->query->get('page');

        $em = $this->getDoctrine()->getManager();

        $posts = $this->get('app.PostHelper')->getLastPosts(10);
        $lastPosts = $this->get('app.PostHelper')->getLastPosts(5);

        $paginationPosts = $em->getRepository(Post::class)->getAllPosts($thisPage, $this->getParameter('app.pgManager.limit'));

        $pagesParameters = $this->get('app.pgManager')->paginate($thisPage, $paginationPosts);

        return array(
            'paginationPosts'   => $paginationPosts,
            'posts'             => $posts,
            'lastPosts'          => $lastPosts,
            'maxPages'          => $pagesParameters[0],
            'thisPage'          => $pagesParameters[1]
        );
    }

    /**
     * @Route("/post/{id}", name="post_show")
     * @Template()
     */
    public function showAction(Post $post)
    {

        $lastPosts = $this->get('app.PostHelper')->getLastPosts(5);

        return array(
            'post'               => $post,
            'lastPosts'          => $lastPosts,
        );

    }
}
