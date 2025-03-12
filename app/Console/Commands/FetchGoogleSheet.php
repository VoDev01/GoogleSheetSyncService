<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\GoogleAPIServices;
use Illuminate\Console\Command;

class FetchGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gsheet:fetch {count? : Ограничить количество выводимых в консоль строк}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Вывод информации об ID модели/комментария';

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
     * @return int
     */
    public function handle()
    {
        $count = $this->argument('count') != null ? ((int)$this->argument('count')) + 1 : 2;
        $service = GoogleAPIServices::getService();
        $spid = env('SPREADSHEET_ID');
        $products = $service->spreadsheets_values->get($spid, $count == 2 ? 'Лист1!A2' : 'Лист1!A2:A' . $count);
        $comments = $service->spreadsheets_values->get($spid, $count == 2 ? 'Лист1!D2' : 'Лист1!D2:D' . $count);

        $productsCount = $products->values != null ? count($products->values) : 0;
        $commentsCount = $comments->values != null ? count($comments->values) : 0;

        $bar = $this->output->createProgressBar($productsCount + $commentsCount);
        $bar->start();
        if ($commentsCount == 1 || $productsCount == 1)
        {
            if ($products->values != null)
            {
                if ($products->values[0] != null)
                    $this->line('ID: ' . $products->values[0][0]);
            }

            if ($comments->values != null)
            {
                if ($comments->values[0] != null)
                    $this->line('Comment: ' .  $comments->values[0][0]);
            }
        }
        else
        {
            for ($i = 0; $i < $productsCount != 0 ? $productsCount : $commentsCount; $i++)
            {
                if ($products->values != null)
                {
                    if ($products->values[$i] != null)
                        $this->line('ID: ' . $products->values[$i][0]);
                }
                if ($comments->values != null)
                {
                    if ($comments->values[$i] != null)
                    {
                        $this->line('Comment: ' .  $comments->values[$i][0]);
                    }
                }
                $bar->advance();
            }
        }
        $bar->finish();

        return 0;
    }
}
