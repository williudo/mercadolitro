<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        //run migrations
        $this->artisan('migrate');
    }

    protected function tearDown(): void
    {
        DB::rollback();
        parent::tearDown();
    }

}
