<?php

use Illuminate\Support\Facades\Route;
use Aws\Sqs\SqsClient;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/publish', function () {
    try {
        $client = new \EventBus\Publisher([
                'client' => new SnsClient([
                    'key' => 'AKIAXUMGJBT6SOZIYN7L',
                    'secret' => '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',
                    'region' => 'us-east-1',
                    'version' => 'latest',
                ]),
                'topics' => [
                    'currency' => 'arn:aws:sns:us-east-1:524804492541:SqsTopic.fifo',
                ]
            ]
        );

        /*$client = new \EventBus\Publisher([
                'credentials' => [
                    'key' => 'AKIAXUMGJBT6SOZIYN7L',
                    'secret' => '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',
                ],
                'region' => 'us-east-1',
                'version' => 'latest',
                'topics' => [
                    'currency' => 'arn:aws:sns:us-east-1:524804492541:SqsTopic.fifo',
                ]
            ]
        );*/

        $response = $client->sendEvent(\EventBus\Constants\EventNames::CURRENCY_UPDATED, ['data' => 'OK']);
        dd($response);

    } catch (AwsException $e) {
        var_dump($e->getMessage());
    }
});

Route::get('/dispatch', function () {
  dispatch(new \App\Jobs\EventHandler([
      'valid' => true,
  ]));
});
