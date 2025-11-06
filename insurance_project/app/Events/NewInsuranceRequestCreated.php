<?php

namespace App\Events;

use App\Models\InsuranceRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewInsuranceRequestCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $insuranceRequest;

    /**
     * Create a new event instance.
     */
    public function __construct(InsuranceRequest $insuranceRequest)
    {
        $this->insuranceRequest = $insuranceRequest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'insurance-request.created';
    }

    /**
     * Data to broadcast
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->insuranceRequest->id,
            'created_at' => $this->insuranceRequest->created_at->toISOString(),
            'message' => 'طلب تأمين جديد (#' . $this->insuranceRequest->id . ')',
        ];
    }
}
