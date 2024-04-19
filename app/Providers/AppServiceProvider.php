<?php

namespace App\Providers;

use App\Interfaces\ParserInterface;
use App\Interfaces\RosterParserInterface;
use App\Repositories\Contracts\RosterEventRepositoryContract;
use App\Repositories\RosterEventRepository;
use App\Services\CCNXParser;
use App\Services\RosterParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();

        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerAppConfigs();
    }

    private function registerAppConfigs(): void
    {
        // Set max length for mysql db
        Schema::defaultStringLength(191);

        // For https scheme if not on local machine
        if(app()->isProduction()){
            URL::forceScheme('https');
        }

        // Remove data wrap from json resource
        JsonResource::withoutWrapping();

        Model::preventLazyLoading(! app()->isProduction());
        
        Model::handleLazyLoadingViolationUsing(
            function ($model, $relation) {
                $class = get_class($model);
            
                info("Attempted to lazy load [{$relation}] on model [{$class}].");
            }
        );

    }

    private function registerServices(): void
    {
        /**
         * ==================================================
         * Services Interface bindings
         * =================================================
         */
        
        $this->app->singleton(RosterParserInterface::class, RosterParser::class);
        $this->app->singleton(ParserInterface::class, CCNXParser::class);
    }

    private function registerRepositories(): void
    {
        /**
         * ==================================================
         * Repository Interface bindings
         * =================================================
         */
        $this->app->singleton(RosterEventRepositoryContract::class, RosterEventRepository::class);

    }
}
