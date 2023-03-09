<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait GeneralTrait
{
    public function validateEmail($emails)
    {

        $emails = explode(",", $emails);
        $validEmailAddress = array();
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // not valid email address logic
            } else {
                $validEmailAddress[] = $email;
            }
        }
        return $validEmailAddress;
    }
}
