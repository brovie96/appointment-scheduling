<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Validator::extend('date_multi_format', function($attribute, $value, $formats)
      {
        // iterate through all formats
        foreach($formats as $format)
        {

          // parse date with current format
          $parsed = date_parse_from_format($format, $value);

          // if value matches given format return true=validation succeeded
          if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0)
          {
            return true;
          }
        }

        // value did not match any of the provided formats, so return false=validation failed
        return false;
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
