<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Crear carpetas necesarias
        $dirs = [
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/cache/data'),
            storage_path('logs'),
            database_path(),
        ];
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
        }

        // Crear SQLite si no existe
        $sqlite = database_path('database.sqlite');
        if (!file_exists($sqlite)) {
            touch($sqlite);
        }

        // Correr migraciones si falta la tabla users
        try {
            \DB::select('SELECT 1 FROM users LIMIT 1');
        } catch (\Exception $e) {
            Artisan::call('migrate', ['--force' => true]);
        }
    }
}
