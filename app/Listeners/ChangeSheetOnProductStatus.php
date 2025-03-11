<?php

namespace App\Listeners;

use App\Enums\StatusEnum;
use App\Services\GoogleAPIServices;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ProductStatusChangedEvent;
use Google\Service\Sheets\ClearValuesRequest;
use Google\Service\Sheets\ValueRange;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeSheetOnProductStatus
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
     * @param  \App\Events\ProductStatusChangedEvent  $event
     * @return void
     */
    public function handle(ProductStatusChangedEvent $event)
    {
        $service = GoogleAPIServices::getService();
        $spid = env('SPREADSHEET_ID');
        $formula = new ValueRange([
            'values' => [
                0 => ['=ПОИСКПОЗ(' . $event->product->id . '; Лист1!A:A; 0)']
            ]
        ]);
        $service->spreadsheets_values->update($spid, '\'Лист2\'!A1', $formula, ['valueInputOption' => 'USER_ENTERED']);
        $productToChange = $service->spreadsheets_values->get($spid, 'Лист2!A1');
        sleep(1);
        if ($event->product->status == StatusEnum::Allowed->value)
            $service->spreadsheets_values->append($spid, '\'Лист1\'!A2:C', new ValueRange([
                'values' =>
                [
                    0 => [
                        $event->product->id,
                        $event->product->name,
                        $event->product->status
                    ]
                ]
            ]), ['valueInputOption' => 'USER_ENTERED']);
        else
            $service->spreadsheets_values->clear(
                $spid,
                '\'Лист1\'!A' . $productToChange->values[0][0] . ':C' . $productToChange->values[0][0],
                new ClearValuesRequest()
            );
        sleep(1);
    }
}