<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{id}", name="category_posts")
     * @Template()
     */
    public function categoryPostsListAction(Request $request, $id)
    {

        dump($request);

        $posts = $this->get('app.PostHelper')->getLastPosts(10);
        $lastPosts = $this->get('app.PostHelper')->getLastPosts(5);

        $paginationPosts = $this->get('app.CategoryHelper')->getPaginatePosts($request, $id);


//        $paginationPosts = $this->get('app.CategoryHelper')->getPaginatePosts($request, $id)->paginationPosts;
//        $pagesParameters = $this->get('app.CategoryHelper')->getPaginatePosts($request, $id)->pagesParameters;

        $categories = $this->get('app.CategoryHelper')->getLastCategories(5);

        return array(
            'paginationPosts'   => $paginationPosts->paginationPosts,
            'posts'             => $posts,
            'lastPosts'         => $lastPosts,
            'categories'        => $categories,
            'maxPages'          => $paginationPosts->pagesParameters[0],
            'thisPage'          => $paginationPosts->pagesParameters[1]
        );

    }

}