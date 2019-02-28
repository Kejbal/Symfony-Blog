<?php

namespace App\Tests\Service;

use App\Service\UrlService;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testSlug()
    {
        $text = 'sdf@ dfs#R.TA2';
        $slug = UrlService::slug($text);
        $this->assertEquals("sdf-dfs-r-ta2", $slug);

    }

}