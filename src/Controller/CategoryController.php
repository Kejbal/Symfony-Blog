<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use App\Service\UrlService;
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
        $slug = $request->attributes->get('slug');

        if (is_numeric($slug)) {
            $category_id = (int) $request->attributes->get('slug');
            if ($category_id > 0) {
                $category_row = $category->findOneBy(['category_id' => $category_id]);
            } else {
                $category_row = new Category;
            }
        } else {
            $slug = UrlService::slug($slug);
            $category_row = $category->findOneBy(['slug' => $slug]);
            $category_id = $category_row->getId();
        }

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
        $this->_data_view['current_category'] = ($category_row->getSlug() ? $category_row->getSlug() : $category_row->getId());

        $this->_data_view['controller_name'] = 'CategoryController';
        return $this->render('category/index.html.twig', $this->_data_view);
    }
}