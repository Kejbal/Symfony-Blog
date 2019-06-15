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
    public function index(Request $request, BlogPostRepository $blog_post)
    {
        $page = (int) $request->attributes->get('page');
        $limit = 5;
        $show_button_older = false;
        $show_button_newer = false;

        if ($page > 1) {
            $limit_offset = ($page - 1) * $limit;
            $show_button_newer = true;
        } else {
            $limit_offset = 0;
            $page = 1;
        }

        $posts = $blog_post->findBy(['draft' => '0'], ['id' => 'DESC'], $limit, $limit_offset);

        $all_posts = $blog_post->findBy(['draft' => '0']);
        if (count($all_posts) > $limit * $page) {
            $show_button_older = true;
        }

        $this->_dataView['controller_name'] = 'IndexController';
        $this->_dataView['posts'] = $posts;
        $this->_dataView['show_button_older'] = $show_button_older;
        $this->_dataView['show_button_newer'] = $show_button_newer;
        $this->_dataView['current_page'] = $page;
        return $this->render('index/index.html.twig', $this->_dataView);
    }
}