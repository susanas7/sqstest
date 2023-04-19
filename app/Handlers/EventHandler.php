<?php

namespace App\Handlers;

class EventHandler
{
    public function handle($job, array $data)
    {
        dd('EVENT HANDLER', $job, $data);
    }
}
