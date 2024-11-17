<?php

// Фейк API
// В ТЗ были указаны endpoints book и approve, так что используем их

class Api {
    public static function bookEndPoint($eventId, $eventDate, $typeAndCountTickets, $barcode) {
        $status = [
            'message' => 'order successfully booked', 
            'error' => 'barcode already exists',
        ];
        $randomKey = array_rand($status);
        return $status[$randomKey];
    }

    public static function approveEndPoint($barcode) {
        $status = [
            'message' => 'order successfully approved', 
            'error1' => 'event cancelled', 
            'error2' => 'no tickets', 
            'error3' => 'no seats',
            'error4' => 'removed',
        ];
        $randomKey = array_rand($status);
        return $status[$randomKey];
    }
}
