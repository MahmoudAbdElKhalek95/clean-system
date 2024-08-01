<?php

namespace App\Providers;

use App\Models\Archive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

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
        Paginator::useBootstrap();
        if (app()->runningInConsole()) {
            return;
        }

        // Model::shouldBeStrict(true);

        if (!session()->has('activeArchive')) {
            $archive=Archive::where('status', 1)->first();
            if($archive) {
                $archive_id=$archive->id;
                session()->put('activeArchiveName', $archive->name);
            } else {
                $archive_id=0;
            }
            session()->put('activeArchive', $archive_id);
        }
        JsonResource::withoutWrapping();

        Validator::extend('numbers', function ($attributes, $value, $parameters, $validation) {
            $numbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
            $input = $value;
            if (!$input) {
                return false;
            }
            $chars = preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY);

            if (!$chars) {
                return false;
            }

            foreach ($chars as $char) {
                if (!in_array($char, $numbers)) {
                    return false;
                }
            }

            return true;
        });
    }
}
