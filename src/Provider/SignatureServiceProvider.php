<?php

namespace Aron\Signature\Provider;

use Aron\Signature\Service\AuthSignatureService;
use Illuminate\Support\ServiceProvider;

class SignatureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('Signature', AuthSignatureService::class);
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
            __DIR__ . '/../../config/signature.php' => config_path('signature.php'),
        ]);
    }
}
