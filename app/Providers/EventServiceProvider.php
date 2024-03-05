<?php

namespace App\Providers;

use App\Events\ClientPlan\ClientPlanUpdated;
use App\Events\PushNotificationEvent;
use App\Events\TherapistInvoice\TherapistInvoiceHandler;
use App\Listeners\ClientPlan\CreateClientNotification;
use App\Listeners\HandleTherapistInvoice;
use App\Listeners\SendPushNotification;
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

        TherapistInvoiceHandler::class => [
            HandleTherapistInvoice::class,
        ],
        ClientPlanUpdated::class => [
            CreateClientNotification::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
