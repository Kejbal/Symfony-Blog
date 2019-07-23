<?php
namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class ControllerBase extends AbstractController
{
    protected $dataView = [];

    public function __construct(
        CategoryRepository $categories,
        BlogPostRepository $blogPost,
        LanguageRepository $languages,
        RequestStack $requestStack
    ) {

        $request = $requestStack->getCurrentRequest();
        $locale = ($request !== null && $request->getLocale() ? $request->getLocale() : 'en');
        $language = $languages->findOneBy(array('iso_code' => $locale));

        $links = array();
        $categories = $categories->findBy(array('language' => [$language->getId(), null]));
        foreach ($categories as $category) {
            $post = $blogPost->findOneBy(array('category' => $category->getId()));
            if ($post) {
                $links[] = $category;
            }
        }

        $this->dataView['links'] = $links;
        $this->dataView['languages'] = $languages->findBy(array('status' => 1));
        $this->dataView['languageIsoCode'] = $language->getIsoCode();
    }
}
