<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testTheApplicationReturnsASuccessfulResponse(): void
    {
        $response = $this->get("/");

        $response->assertStatus(200);
    }
}
