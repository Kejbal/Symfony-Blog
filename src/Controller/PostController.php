<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends ControllerBase
{
    /**
     * @Route("/post", name="post")
     */
    public function index(Request $request, BlogPostRepository $blog_post)
    {

        $post_id = $request->attributes->get('post_id');

        if ($post_id) {
            $post = $blog_post->findOneBy(['id' => $post_id]);
        } else {
            $post = false;
        }

        $this->_data_view['post'] = $post;
        $this->_data_view['controller_name'] = 'PostController';
        return $this->render('post/index.html.twig', $this->_data_view);
    }
}