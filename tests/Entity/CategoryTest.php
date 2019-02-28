<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Service\UrlService;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public function testEntity()
    {

        $category = new Category();

        $category->getId();

        $category->setName('Name');
        $this->assertEquals("Name", $category->getName());

        $slug = UrlService::slug($category->getName());
        $this->assertEquals($slug, $category->getSlug());

        $post = new BlogPost();

        $post->setTitle('Title');

        $post->setBody('<div>Body</div>');

        $post->setDraft(false);

        $category->addBlogPost($post);
        $this->assertNotEmpty($category->getBlogPost());
        $category->removeBlogPost($post);
        $this->assertEmpty($category->getBlogPost());

        $category->getId();

    }
}