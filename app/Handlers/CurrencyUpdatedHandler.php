<?php

namespace App\Handlers;

use EventBus\Contracts\HandlerContract;

class CurrencyUpdatedHandler implements HandlerContract
{
    private array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        dump('CurrencyUpdatedHandler');
        dump($this->data);
    }
}
