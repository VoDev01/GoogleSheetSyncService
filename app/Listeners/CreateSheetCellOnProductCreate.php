<?php

namespace App\Listeners;

use App\Enums\StatusEnum;
use App\Events\ProductCreatedEvent;
use App\Services\GoogleAPIServices;
use Google\Service\Sheets\ValueRange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSheetCellOnProductCreate
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
     * @param  \App\Events\ProductCreatedEvent  $event
     * @return void
     */
    public function handle(ProductCreatedEvent $event)
    {
        $service = GoogleAPIServices::getService();
        $spid = env('SPREADSHEET_ID');
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
            ]), 
        ['valueInputOption' => 'USER_ENTERED']);
    }
}
