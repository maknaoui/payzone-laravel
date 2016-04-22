<?php
namespace Yassine\Payzonepayment;
use Illuminate\Support\ServiceProvider;

class Connect2PayClientServiceProvider extends ServiceProvider {
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['connect2payclient'] = $this->app->share(function($app)
        {
            return new PaypalPayment();
        });
        $this->publishes([
            __DIR__.'/../../config/payzone_payment.php' => config_path('payzone_payment.php'),
        ]);
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('payzone_payment');
    }
}