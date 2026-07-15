<?php

namespace App\Http\Middleware;

use App\Language;
use App\Menu;
use App\SocialIcons;
use App\SupportInfo;
use App\Widgets;
use Closure;

class GlobalVariableMiddleware
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

        view()->composer('frontend/*', function ($view) {
            $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
            $all_social_item = SocialIcons::all();
            $all_support_item = SupportInfo::where('lang',$lang)->get();
            $all_language = Language::where('status', 'publish')->get();
            $primary_menu = Menu::where(['status' => 'default' ,'lang' => $lang])->first();
            $top_menu = Menu::where(['id' => get_static_option('top_bar_'.$lang.'_right_menu')])->first();
            $footer_widgets = Widgets::orderBy('widget_order','ASC')->get();

            $view->with('all_support_item', $all_support_item);
            $view->with('all_social_item', $all_social_item);
            $view->with('all_language', $all_language);
            $view->with('primary_menu_id', !empty($primary_menu) ? $primary_menu->id : '');
            $view->with('top_menu_id', !empty($top_menu) ? $top_menu->id : '');
            $view->with('footer_widgets', $footer_widgets);
            $view->with('user_select_lang_slug', $lang);
        });

        return $next($request);
    }
}
