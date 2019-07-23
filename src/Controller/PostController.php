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
        $post = new BlogPost;
        if (empty($slug)) {
            $slug = 0;
        }

        if (is_numeric($slug)) {
            $post_id = (int) $slug;
            if ($post_id > 0) {
                $post = $blogPost->findOneBy(['id' => $slug]);
            }
        } elseif (!empty($slug)) {
            $slug = UrlService::slug($slug);
            $post = $blogPost->findOneBy(['slug' => $slug]);
        }

        $this->dataView['post'] = $post;
        $this->dataView['controllerName'] = 'PostController';
        return $this->render('post/index.html.twig', $this->dataView);
    }
}
