<?php

namespace App\Console\Commands;

use Log;
use App\TemporaryImage;
use Illuminate\Console\Command;

class deleteTemporaryImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dti:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina tutte le immagini temporanee non associate ad un campione';

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
     * Scrivi su log
     */
    public function log($msg)
    {
        Log::info($msg);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
        
        $img = TemporaryImage::all();
        foreach ($img as $key => $value) 
        {
            $value->delete();
        }

        $this->log('Operazione completata');

        $this->info('dti:Cron Command Run successfully!');
    }
}
