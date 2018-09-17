<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CatalogTest extends TestCase
{
    public function testAll()
    {
        $response = $this->json('GET', 'api/categories/all');
        $response->assertStatus(200)->assertJson([
            'success' => true
        ]);
    }
}
