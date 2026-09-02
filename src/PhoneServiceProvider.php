<?php

namespace Propaganistas\LaravelPhone;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
use libphonenumber\PhoneNumberUtil;
use Propaganistas\LaravelPhone\Rules\Phone as PhoneRules;
use Propaganistas\LaravelPhone\Validation\Phone as PhoneValidator;

class PhoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('libphonenumber', function ($app) {
            return PhoneNumberUtil::getInstance();
        });

        $this->app->alias('libphonenumber', PhoneNumberUtil::class);

        $this->callAfterResolving('validator', function (Factory $validator) {
            $validator->extendDependent('phone', PhoneValidator::class . '@validate');
        });

        Rule::macro('phone', function () {
            return new PhoneRules();
        });
    }
}
