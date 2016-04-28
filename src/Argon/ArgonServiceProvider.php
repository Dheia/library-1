<?php namespace October\Rain\Argon;

use October\Rain\Argon\Argon;
use October\Rain\Support\ServiceProvider;

class ArgonServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $locale = $this->app['translator']->getLocale();

        Argon::setFallbackLocale($this->getFallbackLocale($locale));
        Argon::setLocale($locale);

        $this->app['events']->listen('locale.changed', function($locale) {
            Argon::setFallbackLocale($this->getFallbackLocale($locale));
            Argon::setLocale($locale);
        });
    }

    /**
     * Split the locale and use it as the fallback.
     */
    protected function getFallbackLocale($locale)
    {
        if ($position = strpos($locale, '-')) {
            return substr($locale, 0, $position);
        }

        return $this->app['config']->get('app.fallback_locale');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
