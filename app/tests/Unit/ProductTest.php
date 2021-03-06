<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    public function testAll()
    {
        $response = $this->json('GET', 'api/products/all');
        $response->assertStatus(200)->assertJson([
            'success' => true
        ]);
    }
}
