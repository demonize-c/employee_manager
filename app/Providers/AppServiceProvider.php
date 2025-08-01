<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // in app/Providers/AppServiceProvider.php register() method
        // UrlGenerator::macro('alternateHasCorrectSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
        //     $ignoreQuery[] = 'signature';

        //     // ensure the base path is applied to absolute url
        //     $absoluteUrl = url($request->path()); // forceRootUrl and forceScheme will apply
        //     $url = $absolute ? $absoluteUrl : '/'.$request->path();
            
        //     $queryString = collect(explode('&', (string) $request->server->get('QUERY_STRING')))
        //         ->reject(fn ($parameter) => in_array(Str::before($parameter, '='), $ignoreQuery))
        //         ->join('&');
        //     $original = rtrim($url.'?'.$queryString, '?');
        //     $signature = hash_hmac('sha256', $original, call_user_func($this->keyResolver));
        //     return hash_equals($signature, (string) $request->query('signature', ''));
        // });

        // UrlGenerator::macro('alternateHasValidSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
        //     return \URL::alternateHasCorrectSignature($request, $absolute, $ignoreQuery)
        //         && \URL::signatureHasNotExpired($request);
        // });

        Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
            return true;
            // return \URL::alternateHasValidSignature($this, $absolute, $ignoreQuery);
        });
    }

    public function boot(UrlGenerator $url)
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    //     //Paginator::useBootstrapFive();
    // }
}
