<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public function testEntity()
    {

        $category = new Category();

        $category->getId();

        $category->setName('Name');
        $this->assertEquals("Name", $category->getName());

        $category->setSlug('Ah#l4 p!Ein');
        $this->assertEquals('ah-l4-p-ein', $category->getSlug());

        $language = new Language;
        $category->setLanguage($language);
        $this->assertEquals($language, $category->getLanguage($language));

        $post = new BlogPost();

        $post->setTitle('Title');

        $post->setBody('<div>Body</div>');

        $post->setDraft(false);

        $category->addBlogPost($post);
        $this->assertNotEmpty($category->getBlogPost());
        $category->removeBlogPost($post);
        $this->assertEmpty($category->getBlogPost());

    }
}