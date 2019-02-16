<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlogPostRepository;

class IndexController extends ControllerBase
{
    /**
     * @Route("/index", name="index")
     */
    public function index(BlogPostRepository $blog_post)
    {
        $posts = $blog_post->findBy(['draft' => '0'], ['id' => 'DESC'], 5);

        $this->_data_view['controller_name'] = 'IndexController';
        $this->_data_view['posts'] = $posts;
        return $this->render('index/index.html.twig', $this->_data_view);
    }
}