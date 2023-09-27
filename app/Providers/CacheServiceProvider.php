<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_action('wp_update_nav_menu', function ($menuId, $menuData = []) {
            $themeLocations = collect(get_nav_menu_locations());
            Cache::forget('navigation_' . $themeLocations->search($menuId));
        }, 10, 2);

        add_action('admin_bar_menu', function () {
            global $wp_admin_bar;
            $wp_admin_bar->add_menu([
                'id' => 'clear-cache',
                'title' => isset($_GET['clear_acorn_cache']) && $_GET['clear_acorn_cache'] === 'success'
                    ? '<span class="ab-icon dashicons dashicons-yes"></span>' . __('Acorn cache cleared', 'sage')
                    : __('Clear Acorn cache', 'sage'),
                'href' => wp_nonce_url(admin_url('admin-ajax.php?action=clear_acorn_cache'), 'clear_acorn_cache_' . get_current_user_id()),
                'meta' => [
                    'title' =>  __('Clear Acorn cache', 'sage'),
                ],
            ]);
        }, 100);

        add_action('wp_ajax_clear_acorn_cache', function () {
            if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'clear_acorn_cache_' . get_current_user_id()) || !current_user_can('edit_posts')) {
                wp_die(__('Security check', 'sage'));
            }

            Cache::flush();

            $redirect = add_query_arg('clear_acorn_cache', 'success', wp_get_referer());
            wp_safe_redirect($redirect);
            exit;
        });
    }
}
