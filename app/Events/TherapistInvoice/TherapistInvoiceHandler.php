<?php

namespace App\Events\TherapistInvoice;

use App\Enums\InvoiceItemTypeEnum;
use App\Interfaces\TherapistInvoiceInterface;
use App\Models\BookAppointment;
use App\Models\ClientPlanSubscription;
use App\Models\UserLecture;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TherapistInvoiceHandler implements TherapistInvoiceInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ClientPlanSubscription|UserLecture|BookAppointment $model)
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

    public function getPrice()
    {
        if ($this->model instanceof ClientPlanSubscription)
            return $this->model->price;
        elseif ($this->model instanceof BookAppointment)
            return $this->model->price;
        else
            $this->model->lecture->price;
    }

    public function getType()
    {
        if ($this->model instanceof ClientPlanSubscription)
            return InvoiceItemTypeEnum::PLANSUBSCRIPTION->value;
        elseif ($this->model instanceof BookAppointment)
            return InvoiceItemTypeEnum::BOOKAPPOINTMENT->value;
        else
            return InvoiceItemTypeEnum::LECTURE->value;
    }

    public function getDetails()
    {
        if ($this->model instanceof ClientPlanSubscription)
            return json_encode([
                'title' => $this->model->plan->name,
                'price' => $this->model->plan->price,
                'duration' => $this->model->plan->duration
            ]);
        elseif ($this->model instanceof BookAppointment)
            return json_encode([
                'date' => $this->model->date,
                'time' => $this->model->time,
                'price' => $this->model->price,
            ]);
        else
            return json_encode([
                'title' => $this->model->lecture->title,
                'price' => $this->model->lecture->price,
                'type' => $this->model->lecture->type,
                'duration' => $this->model->lecture->duration
            ]);
    }
}
