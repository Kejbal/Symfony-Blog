<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use App\Service\UrlService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends ControllerBase
{
    /**
     * @Route("/post", name="post")
     */
    public function index(Request $request, BlogPostRepository $blogPost)
    {

        $slug = $request->attributes->get('slug');

        if (empty($slug)) {
            $slug = 0;
        }

        if (is_numeric($slug)) {
            $post_id = (int) $slug;
            if ($post_id > 0) {
                $post = $blogPost->findOneBy(['id' => $slug]);
            } else {
                $post = new BlogPost;
            }
        } elseif (!empty($slug)) {
            $slug = UrlService::slug($slug);
            $post = $blogPost->findOneBy(['slug' => $slug]);
        }

        $this->_dataView['post'] = $post;
        $this->_dataView['controllerName'] = 'PostController';
        return $this->render('post/index.html.twig', $this->_dataView);
    }
}
