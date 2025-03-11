<?php

namespace App\Console;

use App\Models\Product;
use App\Enums\StatusEnum;
use Illuminate\Support\Stringable;
use App\Services\GoogleAPIServices;
use Illuminate\Support\Facades\Log;
use Google\Service\Sheets\ValueRange;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            Log::info('Running');
            $service = GoogleAPIServices::getService();
            $spid = env('SPREADSHEET_ID');
            $sheetValues = $service->spreadsheets_values->get($spid, 'A2:C');
            dump($sheetValues);
            $sheetValuesToDelete = new Collection();
            if($sheetValues->getValues() != null)
            {
                foreach($sheetValues as $value)
                {
                    if(Product::where('id', $value[0])->get()->status == 'Prohibited')
                    {
                        $sheetValuesToDelete->add(Product::where('id', $value[0])->get());
                    }
                }
            }
            $products = Product::where('status', StatusEnum::Allowed->value)->get();
            $productsValues = new Collection();
            foreach($products as $product)
            {
                $productsValues->add([$product->id, $product->name, $product->status]);
            }
            $postBody = new ValueRange([
                'values' => $productsValues->toArray()
            ]);
            dump($postBody);
            $service->spreadsheets_values->update($spid, 'A1:C', $postBody, ['valueInputOption' => 'USER_ENTERED']);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
