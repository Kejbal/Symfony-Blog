<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class BlogPostTest extends TestCase
{

    public function testEntity()
    {

        $post = new BlogPost();

        $post->getId();

        $post->setTitle('Title');
        $this->assertEquals("Title", $post->getTitle());

        $post->setBody('<div>Body</div>');
        $this->assertEquals("<div>Body</div>", $post->getBody());

        $post->setDraft(false);
        $this->assertEquals(false, $post->getDraft());

        $category = new Category();
        $category->setName('test');
        $post->setCategory($category);
        $this->assertEquals($category, $post->getCategory());

    }
}