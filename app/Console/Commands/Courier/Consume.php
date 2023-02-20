<?php

namespace App\Console\Commands\Courier;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\Sqs\SqsClient;
use Illuminate\Console\Command;
use ZBateson\MailMimeParser\Header\HeaderConsts;
use ZBateson\MailMimeParser\Message;

const HEADER_SPAM_VERDICT = 'X-SES-Spam-Verdict';
const HEADER_VIRUS_VERDICT = 'X-SES-Virus-Verdict';

class Consume extends Command
{
    private S3Client $s3Client;

    private SqsClient $sqsClient;

    protected $signature = 'courier:consume';

    protected $description = 'Lorem ipsum dolor sit amet';

    public function __construct()
    {
        parent::__construct();

        $this->s3Client = new S3Client([
            'region' => config('services.courier.region'),
            'credentials' => new Credentials(
                config('services.courier.key'),
                config('services.courier.secret'),
            ),
            'version' => 'latest'
        ]);

        $this->sqsClient = new SqsClient([
            'region' => config('services.courier.region'),
            'credentials' => new Credentials(
                config('services.courier.key'),
                config('services.courier.secret'),
            ),
            'version' => 'latest'
        ]);
    }

    public function handle()
    {
        while (true) {
            $message = $this->receiveMessage();
            if (is_null($message)) {
                continue;
            }

            try {
                $this->handleMessage($message);
            } catch (\Exception $e) {
                $this->error(sprintf('🔴 Failed to process message: %s', $e->getMessage()));
            } finally {
                $this->deleteMessage($message['ReceiptHandle']);
            }
        }
    }

    private function handleMessage($queueMessage)
    {
        $this->info(sprintf('🟡 Start process message: %s', $queueMessage['MessageId']));

        $bodyAsString = $queueMessage['Body'];
        $body = json_decode($bodyAsString, true);

        $messageAsString = $body['Message'];
        $message = json_decode($messageAsString, true);

        $objectAsString = $this->getObjectAsString($message['mail']['messageId']);
        $object = $this->parseMessage($objectAsString, $message['mail']);

        \App\Models\Message::create($object);

        $this->info(sprintf('🟢 Complete process message: %s', $queueMessage['MessageId']));
    }

    private function receiveMessage()
    {
        $result = $this->sqsClient->receiveMessage([
            'MaxNumberOfMessages' => 1,
            'QueueUrl' => config('services.courier.queue_url'),
            'WaitTimeSeconds' => 20
        ]);
        if (!empty($result->get('Messages'))) {
            return $result->get('Messages')[0];
        }

        return null;
    }

    private function deleteMessage(string $receiptHandle)
    {
        $this->sqsClient->deleteMessage([
            'QueueUrl' => config('services.courier.queue_url'),
            'ReceiptHandle' => $receiptHandle
        ]);
    }

    private function getObjectAsString(string $key)
    {
        $result = $this->s3Client->getObject([
            'Bucket' => config('services.courier.bucket'),
            'Key' => $key,
        ]);

        return $result->get('Body')->getContents();
    }

    private function parseMessage(string $messageAsString, array $extras): array
    {
        $message = Message::from($messageAsString, false);

        return [
            'message_id' => $extras['messageId'],
            'from' => $message->getHeaderValue(HeaderConsts::FROM),
            'to' => $message->getHeaderValue(HeaderConsts::TO),
            'spam_verdict' => $message->getHeaderValue(HEADER_SPAM_VERDICT) === 'PASS',
            'virus_verdict' => $message->getHeaderValue(HEADER_VIRUS_VERDICT) === 'PASS',
            'subject' => $message->getHeaderValue(HeaderConsts::SUBJECT),
            'date' => $message->getHeaderValue(HeaderConsts::DATE),
            'html' => $message->getHtmlContent(),
        ];
    }
}
