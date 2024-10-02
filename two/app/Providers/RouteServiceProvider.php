<?php
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $centraldomains = $this->centralDomains();

        $this->routes(function () use ($centraldomains) {
            foreach ($centraldomains as $domain) {
                Route::middleware('api')
                    ->prefix('api')
                    ->domain($domain)
                    ->group(base_path('routes/api.php'));

                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/web.php'));
            }

            // Check if the request is from a central domain
            if (in_array(request()->getHost(), $centraldomains)) {
                // Load the central authentication routes
                Route::middleware('web')
                    ->domain(request()->getHost())
                    ->group(base_path('routes/auth.php')); // Adjust the path accordingly
            } else {
                // Load tenant-specific routes
                Route::middleware(['web', 'tenancy'])
                    ->group(base_path('routes/tenant.php')); // Ensure tenant routes are loaded
            }
        });
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}




// namespace App\Providers;

// use Illuminate\Cache\RateLimiting\Limit;
// use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\RateLimiter;
// use Illuminate\Support\Facades\Route;

// class RouteServiceProvider extends ServiceProvider
// {
//     /**
//      * The path to your application's "home" route.
//      *
//      * Typically, users are redirected here after authentication.
//      *
//      * @var string
//      */
//     public const HOME = '/dashboard';

//     /**
//      * Define your route model bindings, pattern filters, and other route configuration.
//      */
//     public function boot(): void
//     {
//         RateLimiter::for('api', function (Request $request) {
//             return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
//         });

//         $centraldomains=$this->centralDomains();
//         // dd($centraldomains)

        
//         $this->routes(function () use($centraldomains){
//             foreach($centraldomains as $domain){
//                 Route::middleware('api')
//                 ->prefix('api')
//                 ->domain($domain)
//                 ->group(base_path('routes/api.php'));

//             Route::middleware('web')
//                 ->domain($domain)
//                 ->group(base_path('routes/web.php'));
                
//             }  
//         });
//     }

//     protected function centralDomains():array{
//         return config('tenancy.central_domains');
//     }
// }
