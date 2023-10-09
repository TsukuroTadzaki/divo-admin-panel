<?php

use Orchid\Translate\Translate;
use Illuminate\Support\Facades\DB;

if (! function_exists('_t')) {
    function _t($key)
    {
        if (app()->has('translates')) {
            if (! isset(app('translates')[$key])) {
                if (! DB::table(Translate::TABLE)->where('key', $key)->exists()) {
                    $type = str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin')
                        ? Translate::ADMIN_TYPE
                        : Translate::LAYOUT_TYPE;
                    if ($key) {
                        DB::table(Translate::TABLE)->insert([
                            'key' => $key,
                            'language_id' => app('lang')->getDefaultLanguageId(),
                            'type' => $type,
                        ]);
                    }
                }

                return $key;
            }
            if (strlen(app('translates')[$key]) < 1) {
                return $key;
            }

            return app('translates')[$key] ?? $key;
        }
        return $key;
    }
}