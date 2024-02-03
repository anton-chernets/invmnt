<?php

namespace Modules\Article\Tests\Article\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Article\Database\Factories\ArticleFactory;
use Modules\Article\Tests\ArticleTestCase;

class ArticleTest extends ArticleTestCase
{
    use DatabaseMigrations;

    public function test_it_creates_an_product(): void
    {
        new ArticleFactory();

        $this->assertTrue(true);
    }

}
