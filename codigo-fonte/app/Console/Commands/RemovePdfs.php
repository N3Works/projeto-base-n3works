<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemovePdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:pdfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove arquivos pdfs temporarios do storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        \Log::info('-------------------------------------------');
        \Log::info('---------- REGISTROS APAGADOS -------------');
        \Log::info('-------------------------------------------');
        \File::cleanDirectory(storage_path('app').'/public/pdfs');

    }
}
