<?php

namespace App\Providers;

use App\AdminRole;
use App\Blog;
use App\Language;
use App\Menu;
use App\SocialIcons;
use App\SupportInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer(['backend.partials.sidebar', 'backend.partials.sidebar-gwm'],function ($view){
            $auth_role_id = Auth::guard('admin')->user()->role; //->admin_role->permission;
            $get_role_permission = AdminRole::find($auth_role_id);
            $all_permission = (array) json_decode($get_role_permission->permission);
            $view->with('all_menus',$all_permission);
        });

    }
}
