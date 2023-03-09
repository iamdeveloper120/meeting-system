<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Spatie\GoogleCalendar\Event;

trait EventTrait
{
    use GeneralTrait;

    public function createEventOnGoogleCalendar($data)
    {
        $event = new Event;

        $event->name = $data['subject'] ?? 'A new event';
        $event->startDateTime = $data['data'] ?? Carbon::now();
        $validEmails = $this->validateEmail($data['attendees']);
        foreach ($validEmails as $validEmail) {
            $event->addAttendee([
                'email' => $validEmail,
            ]);
        }
        dd($event->save());
    }
}
