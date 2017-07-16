<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class PostController extends Controller
{
    /**
     *
     * @Route("/{page}", defaults={"page" = 1}, name="post_list", requirements={"page": "\d+"})
     * @Template()
     *
     * @param $request Request
     * @param $page integer
     *
     * @return array
     */
    public function listAction(Request $request, $page)
    {
        $posts = $this->get('app.PostHelper')->getLastPosts(10);

        dump($posts);

        $lastPosts = $this->get('app.PostHelper')->getLastPosts(5);

        $paginationPosts = $this->get('app.PostHelper')->getPaginatePosts($page)->paginationPosts;

        $pagesParameters = $this->get('app.PostHelper')->getPaginatePosts($page)->pagesParameters;

        $categories = $this->get('app.CategoryHelper')->getLastCategories(5);

        return array(
            'paginationPosts'   => $paginationPosts,
            'posts'             => $posts,
            'lastPosts'         => $lastPosts,
            'categories'        => $categories,
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
     *
     * @param $request Request
     * @param $post Post
     * @return array
     */
    public function showAction(Request $request, Post $post)
    {

        $lastPosts = $this->get('app.PostHelper')->getLastPosts(5);

        $categories = $this->get('app.CategoryHelper')->getLastCategories(5);

        $categoryList = $post->getCategory();

        $categoryPosts = $this->get('app.PostHelper')->getCategoryPosts($categoryList, 3);

        return array(
            'post'               => $post,
            'categories'         => $categories,
            'lastPosts'          => $lastPosts,
            'categoryPosts'      => $categoryPosts
        );

    }


}
