<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends ControllerBase
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $categories = array();
        $links = array();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy(array());

        foreach ($categories as $category) {
            $post = $this->getDoctrine()->getRepository(BlogPost::class)->findOneBy(array('category' => $category->getId()));
            if ($post) {
                $links[] = $category;
            }
        }
        $this->get('twig')->addGlobal('links', $links);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}