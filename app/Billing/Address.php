<?php

namespace App\Billing;

class Address
{
    public function format($data)
    {
        $address = $data->address_line1;

        if (! is_null($data->address_line2)) {
            $address .= " {$data->address_line2}";
        }

        $address .= '<br>';
        $address .= "{$data->address_city}, {$data->address_state}<br>";
        $address .= "{$data->address_zip}";

        return $address;
    }
}
