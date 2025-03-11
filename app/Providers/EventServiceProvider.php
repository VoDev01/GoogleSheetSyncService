<?php

namespace App\Providers;

use App\Events\ProductDeletedEvent;
use App\Events\ProductStatusChangedEvent;
use App\Listeners\ChangeSheetOnProductStatus;
use App\Listeners\DeleteSheetCellOnProductDelete;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(ProductStatusChangedEvent::class, [ChangeSheetOnProductStatus::class, 'handle']);
        Event::listen(ProductDeletedEvent::class, [DeleteSheetCellOnProductDelete::class, 'handle']);
    }
}
