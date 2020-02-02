<?php

namespace App\Console\Commands;

use App\Http\Controllers\CrawlerController;
use Illuminate\Console\Command;

class CrawlerByDay extends Command
{
    public $crawlerController;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:horoscope';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crawler';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->crawlerController = new CrawlerController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->crawlerController->getHoroscope();

    }

}
