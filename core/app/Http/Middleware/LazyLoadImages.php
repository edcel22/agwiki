<?php

namespace App\Http\Middleware;

use Closure;

class LazyLoadImages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->isSuccessful() && str_contains($response->headers->get('Content-Type'), 'text/html')) {
            $content = $response->getContent();
            $content = preg_replace('/<img(.*?)src=/', '<img$1loading="lazy" src=', $content);
            $response->setContent($content);
        }

        return $response;
    }
}
