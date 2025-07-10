<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class HomeTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHomePageLoadsSuccessfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}

