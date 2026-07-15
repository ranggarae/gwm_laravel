<?php

namespace App\Http\Middleware;

use Closure;

class ModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        switch ($permission){
            case('blogs'):
                return get_static_option('blog_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('job_post'):
                return get_static_option('job_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('events'):
                return get_static_option('events_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('products'):
                return get_static_option('product_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('donations'):
                return get_static_option('donations_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('knowledgebase'):
                return get_static_option('knowledgebase_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('gigs'):
                return get_static_option('gig_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('services'):
                return get_static_option('service_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            case('works'):
                return get_static_option('works_module_status') == 'on' ? $next($request) : redirect()->route('homepage');
                break;
            default:
                return $next($request);
                break;
        }
    }
}
