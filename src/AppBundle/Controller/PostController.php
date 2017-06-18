<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        dump($posts);

        return array(
            'paginationPosts'   => $paginationPosts,
            'posts'             => $posts,
            'lastPosts'          => $lastPosts,
            'maxPages'          => $pagesParameters[0],
            'thisPage'          => $pagesParameters[1]
        );
    }

    /**
     * @Route("/post/new", name="post_new")
     */
    public function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $post = new Post();

        $post->setTitle('test');
        $post->setThumb('http://lorempixel.com/gray/610/350/?24886');
        $post->setContent('test');

        $em->persist($post);

        $em->flush($post);

        return $this->redirectToRoute('post_list');

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
