<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        TestResponse::macro('assertJsonHasErrors', function($keys = []) {
            Assert::assertArrayHasKey('errors', $this->json());

            foreach (array_wrap($keys) as $key) {
                Assert::assertArrayHasKey($key, $this->json()['errors']);
            }
        });
    }
}
