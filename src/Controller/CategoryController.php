<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends ControllerBase
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request, CategoryRepository $category, BlogPostRepository $blog_post)
    {
        $page = (int) $request->attributes->get('page');
        $category_id = (int) $request->attributes->get('category_id');
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

        if ($category_id === 0) {

            $posts = $blog_post->findBy(['draft' => '0'], ['id' => 'DESC'], $limit, $limit_offset);
            $all_posts = $blog_post->findBy(['draft' => '0']);

        } else {
            $posts = $blog_post->findBy(['draft' => '0', 'category' => $category_id], ['id' => 'DESC'], $limit, $limit_offset);
            $all_posts = $blog_post->findBy(['draft' => '0', 'category' => $category_id]);
        }

        if (count($all_posts) > $limit * $page) {
            $show_button_older = true;
        }

        $this->_data_view['controller_name'] = 'IndexController';
        $this->_data_view['posts'] = $posts;
        $this->_data_view['show_button_older'] = $show_button_older;
        $this->_data_view['show_button_newer'] = $show_button_newer;
        $this->_data_view['current_page'] = $page;
        $this->_data_view['current_category'] = $category_id;

        $this->_data_view['controller_name'] = 'CategoryController';
        return $this->render('category/index.html.twig', $this->_data_view);
    }
}