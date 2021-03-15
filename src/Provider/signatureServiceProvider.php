<?php
namespace Aron\Signature\Provider;

use Aron\signature\Service\AuthSignatureService;
use Illuminate\Support\ServiceProvider;

class signatureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('signature', AuthSignatureService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // 发布配置文件
        $this->publishes([
            __DIR__.'/Config/php' => config_path('signature.php'),
        ]);
    }
}
