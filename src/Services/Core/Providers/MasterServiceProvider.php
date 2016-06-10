<?php

namespace Mega\Services\Core\Providers;

use Mega\Modules\User\Providers\UserServiceProvider;
use Mega\Services\Core\Providers\Abstracts\ServiceProvider;
use Mega\Services\Core\Route\Providers\ApiBaseRouteServiceProvider;

/**
 * Class MasterServiceProvider
 * The main Service Provider where all Service Providers gets registered
 * this is the only Service Provider that gets injected in the Config/app.php.
 *
 * Class MasterServiceProvider
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class MasterServiceProvider extends ServiceProvider
{
    /**
     * Application Service Provides.
     *
     * @var array
     */
    private $serviceProviders = [
        ApiBaseRouteServiceProvider::class,
        // Modules Service Providers:
        UserServiceProvider::class,
        // ...
    ];

    public function boot()
    {
        foreach ($this->serviceProviders as $serviceProvider) {
            $this->app->register($serviceProvider);
        }

        $this->overrideDefaultFractalSerializer();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->changeTheDefaultDatabaseModelsFactoriesPath();
        $this->debugDatabaseQueries(true);
    }
}
