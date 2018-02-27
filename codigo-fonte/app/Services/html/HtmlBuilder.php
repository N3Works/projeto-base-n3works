<?php

namespace  App\Services\Html;

class HtmlBuilder extends \Collective\Html\HtmlBuilder {

    public function script($url, $attributes = [], $secure = null)
    {
        $attributes['src'] = $this->url->asset($this->verifyEnvironment($url), $secure);

        return $this->toHtmlString('<script' . $this->attributes($attributes) . '></script>' . PHP_EOL);
    }

    public function verifyEnvironment($url){

        if (env('APP_ENV') == 'local') {
            $url = $url .'?'. crc32(time());
        } else {
            $url = $url .'?'. crc32(env('APP_VERSION'));
        }
        return $url;
    }
} 