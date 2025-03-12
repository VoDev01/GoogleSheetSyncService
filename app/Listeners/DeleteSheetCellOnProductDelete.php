<?php

namespace App\Listeners;

use App\Events\ProductDeletedEvent;
use App\Services\GoogleAPIServices;
use Google\Service\Sheets\ValueRange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Google\Service\Sheets\ClearValuesRequest;

class DeleteSheetCellOnProductDelete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductDeletedEvent  $event
     * @return void
     */
    public function handle(ProductDeletedEvent $event)
    {
        $service = GoogleAPIServices::getService();
        $spid = env('SPREADSHEET_ID');
        $service->spreadsheets_values->update($spid, '\'Лист2\'!A1', new ValueRange(['values' => '=ПОИСКПОЗ('.$event->product->id.', \'Лист1\'!A:A, 0'], ['valueInputOption' => 'USER_ENTERED']));
        sleep(1);
        $productToChange = $service->spreadsheets_values->get($spid, '\'Лист2\'!A1');
        sleep(1);
        $service->spreadsheets_values->clear($spid, '\'Лист1\'!A'.$productToChange->values[0].':C'.$productToChange->values[0], new ClearValuesRequest());
    }
}