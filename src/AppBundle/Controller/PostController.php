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

        $posts = $em->getRepository(Post::class)->getAllPosts($thisPage, $this->getParameter('app.pgManager.limit'));

        $pagesParameters = $this->get('app.pgManager')->paginate($thisPage, $posts);

        return array(
            'posts' => $posts,
            'maxPages' => $pagesParameters[0],
            'thisPage' => $pagesParameters[1]
        );
    }

//    /**
//     * @Route("/", name="post_list")
//     */
//    public function listAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $allPosts = $em->getRepository(Post::class)->findAll();
//
//        $paginator  = $this->get('knp_paginator');
//
//        $posts = $paginator->paginate(
//            $allPosts, $request->query->getInt('page', 1), 2
//        );
//
//        // parameters to template
//        return $this->render('AppBundle:Post:list.html.twig', array('posts' => $posts));
//    }
}
