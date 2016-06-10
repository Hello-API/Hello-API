<?php

namespace Mega\Services\Core\Test\Abstracts;

use Illuminate\Contracts\Console\Kernel as LaravelKernel;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Mega\Services\Core\Test\Traits\TestingTrait;

/**
 * Class TestCase.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class TestCase extends LaravelTestCase
{

    use TestingTrait;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Setup the test environment, before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // migrate the database
        $this->artisan('migrate');
        // seed the database
        $this->seed('Mega\Services\Core\Seeders\DatabaseSeeder');
    }

    /**
     * Reset the test environment, after each test.
     */
    public function tearDown()
    {
        $this->artisan('migrate:reset');
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $this->baseUrl = env('API_BASE_URL');

        $app = require __DIR__ . '/../../../../../bootstrap/app.php';

        $app->make(LaravelKernel::class)->bootstrap();

        return $app;
    }
}
