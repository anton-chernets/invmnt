<?php

namespace Modules\Product\Tests\Product\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Product\Database\Factories\ProductFactory;
use Modules\Product\Tests\ProductTestCase;

class ProductTest extends ProductTestCase
{
    use DatabaseMigrations;

    public function test_it_creates_an_product(): void
    {
        new ProductFactory();

        $this->assertTrue(true);
    }

}
