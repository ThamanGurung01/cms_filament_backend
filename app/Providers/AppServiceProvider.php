<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::share('footerServices', collect());
        \Illuminate\Support\Facades\View::share('megaMenuCategories', collect());

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::map();
                \Illuminate\Support\Facades\View::share('settings', $settings);

                if (\Illuminate\Support\Facades\Schema::hasTable('menus')) {
                    // Use direct query for IDs to be safe against map() caching
                    $headerMenuId = \App\Models\Setting::where('key', 'header_menu_id')->value('value');
                    $footerCol3MenuId = \App\Models\Setting::where('key', 'footer_col3_menu_id')->value('value');
                    $footerCol4MenuId = \App\Models\Setting::where('key', 'footer_col4_menu_id')->value('value');
                    $footerBottomMenuId = \App\Models\Setting::where('key', 'footer_bottom_menu_id')->value('value');

                    $headerMenu = \App\Models\Menu::find($headerMenuId);
                    $footerCol3Menu = \App\Models\Menu::find($footerCol3MenuId);
                    $footerCol4Menu = \App\Models\Menu::find($footerCol4MenuId);
                    $footerBottomMenu = \App\Models\Menu::find($footerBottomMenuId);

                    \Illuminate\Support\Facades\View::share('headerMenu', $headerMenu);
                    \Illuminate\Support\Facades\View::share('footerCol3Menu', $footerCol3Menu);
                    \Illuminate\Support\Facades\View::share('footerCol4Menu', $footerCol4Menu);
                    \Illuminate\Support\Facades\View::share('footerBottomMenu', $footerBottomMenu);
                } else {
                    \Illuminate\Support\Facades\View::share('headerMenu', null);
                    \Illuminate\Support\Facades\View::share('footerCol3Menu', null);
                    \Illuminate\Support\Facades\View::share('footerCol4Menu', null);
                    \Illuminate\Support\Facades\View::share('footerBottomMenu', null);
                }
            } else {
                \Illuminate\Support\Facades\View::share('settings', []);
                \Illuminate\Support\Facades\View::share('headerMenu', null);
                \Illuminate\Support\Facades\View::share('footerCol3Menu', null);
                \Illuminate\Support\Facades\View::share('footerCol4Menu', null);
                \Illuminate\Support\Facades\View::share('footerBottomMenu', null);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('settings', []);
            \Illuminate\Support\Facades\View::share('headerMenu', null);
            \Illuminate\Support\Facades\View::share('footerCol3Menu', null);
            \Illuminate\Support\Facades\View::share('footerCol4Menu', null);
            \Illuminate\Support\Facades\View::share('footerBottomMenu', null);
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('slug_seos')) {
                // Format path to ensure leading slash for consistency
                $path = '/' . ltrim(request()->path(), '/');
                $slugSeo = \App\Models\SlugSeo::where('slug', $path)->orWhere('slug', request()->path())->first();
                \Illuminate\Support\Facades\View::share('slugSeo', $slugSeo);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('slugSeo', null);
        }
    }
}
