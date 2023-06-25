<?php

namespace App\Providers;

use App\Notice;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\HeaderFooter;
use App\PdfFile;
use App\FixedFile;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set('Asia/Dhaka');

        View::composer('*', function ($view) {
            $header_footer = HeaderFooter::first();
            $pdf_files = PdfFile::orderBy('position', 'asc')->where('status', 1)->get();
            $notices = Notice::orderBy('sort')
                ->get();
            $highLightNotice = Notice::where('sort',2)->first();

            $all_fixed_file = FixedFile::first();
            $view->with('header_footer', $header_footer)
                ->with('all_fixed_file', $all_fixed_file)
                ->with('pdf_files', $pdf_files)
                ->with('notices', $notices)
                ->with('highLightNotice', $highLightNotice);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
