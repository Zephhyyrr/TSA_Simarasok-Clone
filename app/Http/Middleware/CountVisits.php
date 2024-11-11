<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PageVisit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        $pageVisit = PageVisit::where('path', $path)->first();

        if ($pageVisit) {
            $pageVisit->increment('visits');
        } else {
            PageVisit::create([
                'path' => $path,
                'visits' => 1
            ]);
        }

        return $next($request);
    }
}
