<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Medication;

class MedicationNotification extends Notification
{
    use Queueable;

    public $medication;
    public $action;

    public function __construct(Medication $medication, $action)
    {
        $this->medication = $medication;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'medication_id' => $this->medication->id,
            'medication_name' => $this->medication->name,
            'action' => $this->action,
            'details' => $this->getActionDetails()
        ];
    }

    private function getActionDetails()
    {
        switch ($this->action) {
            case 'create':
                return "A new medication '{$this->medication->name}' was added.";
            case 'update':
                return "Medication '{$this->medication->name}' was updated.";
            case 'delete':
                return "Medication '{$this->medication->name}' was deleted.";
            default:
                return "Medication action performed.";
        }
    }
}
