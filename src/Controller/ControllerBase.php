<?php
namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class ControllerBase extends AbstractController
{
    protected $_data_view = [];

    public function __construct(CategoryRepository $categories, BlogPostRepository $blogPost, LanguageRepository $language, RequestStack $requestStack)
    {

        $request = $requestStack->getCurrentRequest();
        $locale = $request->getLocale();
        $language = $language->findOneBy(array('iso_code' => $locale));

        $links = array();
        $categories = $categories->findBy(array('language' => [$language->getId(), null]));

        foreach ($categories as $category) {
            $post = $blogPost->findOneBy(array('category' => $category->getId()));
            if ($post) {
                $links[] = $category;
            }
        }

        $this->_data_view['links'] = $links;

    }

}