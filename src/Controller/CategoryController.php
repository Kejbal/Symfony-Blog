<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use App\Service\UrlService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends ControllerBase
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request, LanguageRepository $language, CategoryRepository $category, BlogPostRepository $blog_post, TranslatorInterface $translator)
    {
        $slug = $request->attributes->get('slug');
        $page = $request->attributes->get('page');

        $locale = $request->getLocale();
        
        $language = $language->findOneBy(array('iso_code' => $locale));

        if (empty($slug)) {
            $slug = 0;
        }

        if (is_numeric($slug)) {
            $category_id = (int) $slug;
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

            $posts = $blog_post->findBy(['draft' => '0', 'language' => [$language->getId(), null]], ['id' => 'DESC'], $limit, $limit_offset);
            $all_posts = $blog_post->findBy(['draft' => '0']);

        } else {
            $posts = $blog_post->findBy(['draft' => '0', 'language' => [$language->getId(), null], 'category' => $category_id], ['id' => 'DESC'], $limit, $limit_offset);
            $all_posts = $blog_post->findBy(['draft' => '0', 'language' => [$language->getId(), null], 'category' => $category_id]);
        }

        if (count($all_posts) > $limit * $page) {
            $show_button_older = true;
        }

        $currentCategory=($category_row->getSlug() ? $category_row->getSlug() : $category_row->getId());

        $this->_dataView['controller_name'] = 'IndexController';
        $this->_dataView['posts'] = $posts;
        $this->_dataView['show_button_older'] = $show_button_older;
        $this->_dataView['show_button_newer'] = $show_button_newer;
        $this->_dataView['current_page'] = $page;
        $this->_dataView['current_category'] = ($currentCategory?$currentCategory:0);

        $this->_dataView['controller_name'] = 'CategoryController';
        return $this->render('category/index.html.twig', $this->_dataView);
    }
}