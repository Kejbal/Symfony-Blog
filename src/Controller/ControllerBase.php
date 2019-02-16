<?php
namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControllerBase extends AbstractController
{
    protected $_data_view = [];

    public function __construct(CategoryRepository $categories, BlogPostRepository $blog_post)
    {
        $links = array();
        $categories = $categories->findBy(array());

        foreach ($categories as $category) {
            $post = $blog_post->findOneBy(array('category' => $category->getId()));
            if ($post) {
                $links[] = $category;
            }
        }

        $this->_data_view['links'] = $links;

    }

}