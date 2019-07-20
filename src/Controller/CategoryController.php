<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends ControllerBase
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request, LanguageRepository $language, CategoryRepository $category, BlogPostRepository $blogPost, TranslatorInterface $translator)
    {
        $slug = $request->attributes->get('slug');
        $page = $request->attributes->get('page');

        $limit = $this->getParameter('post_limit');
        $locale = $request->getLocale();

        if (empty($slug)) {
            $slug = 0;
        }

        $language = $language->findOneBy(array('iso_code' => $locale));

        $categoryRow = $category->findOneBySlug($slug);
        $categoryId = (int) ($categoryRow ? $categoryRow->getId() : 0);

        $showButtonOlder = false;
        $showButtonNewer = false;

        if ($page > 1) {
            $limitOffset = ($page - 1) * $limit;
            $showButtonNewer = true;
        } else {
            $limitOffset = 0;
            $page = 1;
        }

        $args = ['draft' => '0', 'language' => [$language->getId(), null]];

        if ($categoryId > 0) {
            $args['category'] = $categoryId;
        }

        $posts = $blogPost->findBy($args, ['id' => 'DESC'], $limit, $limitOffset);
        $allPosts = $blogPost->findBy($args);

        if (count($allPosts) > $limit * $page) {
            $showButtonOlder = true;
        }

        $this->_dataView['posts'] = $posts;
        $this->_dataView['showButtonOlder'] = $showButtonOlder;
        $this->_dataView['showButtonNewer'] = $showButtonNewer;
        $this->_dataView['currentPage'] = $page;
        $this->_dataView['currentCategory'] = $slug;

        $this->_dataView['controllerName'] = 'CategoryController';
        return $this->render('category/index.html.twig', $this->_dataView);
    }
}