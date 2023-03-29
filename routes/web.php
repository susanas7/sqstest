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
    $queueUrl = config('queue.connections.sqs.prefix') . config('queue.connections.sqs.queue');
    //$queueUrl = 'https://sqs.us-east-1.amazonaws.com/524804492541/SqsQueue.fifo';

    $sqsClient = new SqsClient([
        'credentials' => [
            'key' => 'AKIAXUMGJBT6SOZIYN7L',
            'secret' => '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',
        ],
        'region' => 'us-east-1',
        'version' => 'latest',
    ]);


    try {
        var_dump('ANTES');
        $result = $sqsClient->receiveMessage([
            'AttributeNames' => ['SentTimestamp'],
            'MaxNumberOfMessages' => 10,
            'MessageAttributeNames' => ['All'],
            'QueueUrl' => $queueUrl, // REQUIRED
            'WaitTimeSeconds' => 0,
        ]);
        var_dump('TRY');
        var_dump($result);
        var_dump('result!!!');
        if (!empty($result->get('Messages'))) {
            var_dump($result->get('Messages')[0]);
            $result = $sqsClient->deleteMessage([
                'QueueUrl' => $queueUrl, // REQUIRED
                'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
            ]);
        } else {
            var_dump('ELSE');
            echo "No messages in queue. \n";
        }
    } catch (AwsException $e) {
        dd($e);
        var_dump('errors');
        // output error message if fails
        error_log($e->getMessage());
    }
});


Route::get('/receive', function () {
    $snsClient = new SnsClient([ 'credentials' => [
        'key' => 'AKIAXUMGJBT6SOZIYN7L',
        'secret' => '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' ],
        'region' => 'us-east-1',
        'version' => 'latest',
    ]);

    try {
        $result = $snsClient->publish([
            'Message' => 'pruebaaaaaa 3',
            'TopicArn' => 'arn:aws:sns:us-east-1:524804492541:SqsTopic.fifo',
            'MessageGroupId' => 3
        ]);
        var_dump($result);
    } catch (AwsException $e) {
        var_dump($e->getMessage());
    }
});
