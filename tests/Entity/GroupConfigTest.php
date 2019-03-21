<?php

namespace App\Tests\Entity;

use App\Entity\GroupConfig;
use PHPUnit\Framework\TestCase;

class GroupConfigTest extends TestCase
{

    public function testEntity()
    {

        $group = new GroupConfig();

        $group->getId();

        $group->setName('Name');
        $this->assertEquals("Name", $group->getName());

        /* $post = new BlogPost();

        $post->setTitle('Title');

        $post->setBody('<div>Body</div>');

        $post->setDraft(false);

        $category->addBlogPost($post);
        $this->assertNotEmpty($category->getBlogPost());
        $category->removeBlogPost($post);
        $this->assertEmpty($category->getBlogPost());*/

        $group->getId();

    }
}