<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function testHomeRoute()
    {
        $this->get('/')->assertStatus(200);
    }
    public function testHomeRouteByPost(){
        $this->post('/')->assertStatus(500);

    }
}
