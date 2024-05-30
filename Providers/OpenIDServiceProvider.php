<?php

namespace Modules\OpenID\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Auth;

define('SAMPLE_OAUTH', 'openid');

class OpenIDServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->hooks();
    }

    /**
     * Module hooks.
     */
    public function hooks()
    {
        \Eventy::addFilter('settings.sections', function($sections) {
            $sections['openid'] = ['title' => __('OpenID'), 'icon' => 'user', 'order' => 700];

            return $sections;
        }, 30);

        // Section settings
        \Eventy::addFilter('settings.section_settings', function($settings, $section) {

            if ($section != 'openid') {
                return $settings;
            }

            $settings = \Option::getOptions([
                'openid.active',
                'openid.client_id',
                'openid.client_secret',
                'openid.auth_url',
                'openid.token_url',
                'openid.user_url',
                'openid.scope',
                'openid.mailbox_ids',
            ]);

            return $settings;
        }, 20, 2);

        // Section parameters.
        \Eventy::addFilter('settings.section_params', function($params, $section) {
            if ($section != 'openid') {
                return $params;
            }

            $params = [
                'template_vars' => [],
                'validator_rules' => [],
            ];

            return $params;
        }, 20, 2);

        // Settings view name
        \Eventy::addFilter('settings.view', function($view, $section) {
            if ($section != 'openid') {
                return $view;
            } else {
                return 'openid::index';
            }
        }, 20, 2);

        \Eventy::addFilter('middleware.web.custom_handle.response', function($prev, $rq, $next) {
            $path = $rq->path();
            $loggedIn = Auth::check();

            $settings = \Option::getOptions([
                'openid.active',
                'openid.client_id',
                'openid.auth_url',
                'openid.scope',
            ]);

            if (!$rq->get('disable_openid', false) && $path == 'login' && !$loggedIn &&
                $settings['openid.active'] == 'on') {

                $con = '?';
                if (strpos($settings['openid.auth_url'], '?') !== false) {
                    $con = '&';
                }

                return redirect(
                    sprintf("%s%sclient_id=%s&response_type=code&redirect_uri=%s&scope=%s",
                        $settings['openid.auth_url'],
                        $con,
                        $settings['openid.client_id'],
                        route('openid_callback'),
                        $settings['openid.scope']
                    )
                );
            }

            return $prev;
        }, 10, 3);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTranslations();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('openid.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'openid'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/openid');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/openid';
        }, \Config::get('view.paths')), [$sourcePath]), 'openid');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadJsonTranslationsFrom(__DIR__ .'/../Resources/lang');
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
