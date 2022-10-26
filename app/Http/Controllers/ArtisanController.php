<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
    public function config_cache()
    {
        Artisan::call("config:cache");
    }

    public function config_clear()
    {
        Artisan::call("config:clear");
    }

    public function view_cache()
    {
        Artisan::call("view:cache");
    }

    public function view_clear()
    {
        Artisan::call("view:clear");
    }

    public function route_cache()
    {
        Artisan::call("route:cache");
    }

    public function route_clear()
    {
        Artisan::call("route:clear");
    }

    public function migrate()
    {
        Artisan::call("migrate --seed");
    }
}
