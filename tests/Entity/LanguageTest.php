<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class LangaugeTest extends TestCase
{
    /**
     * @group entity
     * @group entity-langauge
     */

    public function testEntity()
    {
        $language = new Language();

        $language->getId();

        $language->setName('Name');
        $this->assertEquals("Name", $language->getName());

        $language->setIsoCode('pl');
        $this->assertEquals('pl', $language->getIsoCode());

        $language->setStatus(1);
        $this->assertEquals(1, $language->getStatus());

        $category = new Category;
        $language->addCategory($category);
        $this->assertNotEmpty($language->getCategories());
        $language->removeCategory($category);
        $this->assertEmpty($language->getCategories());

        $post = new BlogPost;
        $language->addBlogPost($post);
        $this->assertNotEmpty($language->getBlogPosts());
        $language->removeBlogPost($post);
        $this->assertEmpty($language->getBlogPosts());
    }
}
