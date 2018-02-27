<?php

Namespace App\Services\Html;
use Collective\Html\FormBuilder;

class HtmlServiceProvider extends \Collective\Html\HtmlServiceProvider {

    /**
     * Register the form builder instance.
     */
    protected function registerFormBuilder()
    {
        //bindShared 
        $this->app->singleton('form', function($app)
        {
            $form = new FormBuilder($app['html'], $app['url'], $app ['view'], $app['session.store']->getToken());

            return $form->setSessionStore($app['session.store']);
        });
    }

    /**
     * Register the html builder instance.
     */
    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', function($app)
        {
            return new HtmlBuilder($app['url'],$app['view']);
        });
    }
} 