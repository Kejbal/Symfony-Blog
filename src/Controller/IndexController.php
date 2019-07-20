<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends ControllerBase
{
    /**
     * @Route("/index", name="index")
     */
    public function index(Request $request, BlogPostRepository $blogPost)
    {
        $page = (int) $request->attributes->get('page');
        $limit = $this->getParameter('post_limit');
        $showButtonOlder = false;
        $showButtonNewer = false;

        if ($page > 1) {
            $limitOffset = ($page - 1) * $limit;
            $showButtonNewer = true;
        } else {
            $limitOffset = 0;
            $page = 1;
        }

        $posts = $blogPost->findBy(['draft' => '0'], ['id' => 'DESC'], $limit, $limitOffset);

        $allPosts = $blogPost->findBy(['draft' => '0']);
        if (count($allPosts) > $limit * $page) {
            $showButtonOlder = true;
        }

        $this->_dataView['controllerName'] = 'IndexController';
        $this->_dataView['posts'] = $posts;
        $this->_dataView['showButtonOlder'] = $showButtonOlder;
        $this->_dataView['showButtonNewer'] = $showButtonNewer;
        $this->_dataView['currentPage'] = $page;
        return $this->render('index/index.html.twig', $this->_dataView);
    }
}