<?php

namespace App\Events\ClientPlan;

use App\Enums\InvoiceItemTypeEnum;
use App\Interfaces\TherapistInvoiceInterface;
use App\Models\BookAppointment;
use App\Models\ClientPlanSubscription;
use App\Models\TherapistPlan;
use App\Models\UserLecture;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientPlanUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ClientPlanSubscription $model,public $client)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
