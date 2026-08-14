<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));

        if (in_array($locale, ['en', 'ru', 'tm'])) {
            App::setLocale($locale);

            Carbon::setLocale($locale === 'tm' ? 'tk' : $locale);
        }

        return $next($request);
    }
}