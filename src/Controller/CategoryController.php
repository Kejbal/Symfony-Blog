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
    public function index(Request $request, LanguageRepository $language, CategoryRepository $category, BlogPostRepository $blogPost, TranslatorInterface $translator)
    {
        $slug = $request->attributes->get('slug');
        $page = $request->attributes->get('page');

        $locale = $request->getLocale();
        
        $language = $language->findOneBy(array('iso_code' => $locale));

        if (empty($slug)) {
            $slug = 0;
        }

        if (is_numeric($slug)) {
            $categeryId = (int) $slug;
            if ($categeryId > 0) {
                $categoryRow = $category->findOneBy(['category_id' => $categeryId]);
            } else {
                $categoryRow = new Category;
            }
        } else {
            $slug = UrlService::slug($slug);
            $categoryRow = $category->findOneBy(['slug' => $slug]);
            $categeryId = $categoryRow->getId();
        }

        $limit = 5;
        $showButtonOlder = false;
        $showButtonNewer = false;

        if ($page > 1) {
            $limitOffset = ($page - 1) * $limit;
            $showButtonNewer = true;
        } else {
            $limitOffset = 0;
            $page = 1;
        }

        if ($categeryId === 0) {

            $posts = $blogPost->findBy(['draft' => '0', 'language' => [$language->getId(), null]], ['id' => 'DESC'], $limit, $limitOffset);
            $allPosts = $blogPost->findBy(['draft' => '0']);

        } else {
            $posts = $blogPost->findBy(['draft' => '0', 'language' => [$language->getId(), null], 'category' => $categeryId], ['id' => 'DESC'], $limit, $limitOffset);
            $allPosts = $blogPost->findBy(['draft' => '0', 'language' => [$language->getId(), null], 'category' => $categeryId]);
        }

        if (count($allPosts) > $limit * $page) {
            $showButtonOlder = true;
        }

        $currentCategory=($categoryRow->getSlug() ? $categoryRow->getSlug() : $categoryRow->getId());

        $this->_dataView['posts'] = $posts;
        $this->_dataView['showButtonOlder'] = $showButtonOlder;
        $this->_dataView['showButtonNewer'] = $showButtonNewer;
        $this->_dataView['currentPage'] = $page;
        $this->_dataView['currentCategory'] = ($currentCategory?$currentCategory:0);

        $this->_dataView['controllerName'] = 'CategoryController';
        return $this->render('category/index.html.twig', $this->_dataView);
    }
}