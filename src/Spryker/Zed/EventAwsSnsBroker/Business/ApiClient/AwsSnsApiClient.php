<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\ApiClient;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;

class AwsSnsApiClient implements EventAwsSnsApiClientInterface
{
    /**
     * @var SnsClient
     */
    protected $awsSnsClient;

    public function __construct()
    {
        $this->awsSnsClient = new SnsClient([
            'credentials' => [
                'key' => 'test',
                'secret' => 'test',
            ],
            'endpoint' => 'http://localhost.localstack.cloud:4566',
            'region' => 'eu-central-1',
            'version' => '2010-03-31'
        ]);
    }

    /**
     * @param string $topicName
     *
     * @return string
     */
    public function createTopic(string $topicName): string
    {
        try {
            $result = $this->awsSnsClient->createTopic([
                'Name' => $topicName,
            ]);

            var_dump($result);
        } catch (AwsException $e) {
            var_dump($e->getMessage());
        }

        return $result['TopicArn'];
    }

    /**
     * @param string $topicArn
     * @param string $endpoint
     * @param string $protocol
     *
     * @return string
     */
    public function registerSubscriber(string $topicArn, string $endpoint, string $protocol): string
    {
        try {
            $result = $this->awsSnsClient->subscribe([
                'Protocol' => $protocol,
                'Endpoint' => $endpoint,
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $topicArn,
            ]);
            var_dump($result);
        } catch (AwsException $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @param string $topicArn
     * @param string $message
     *
     * @return string
     */
    public function publishEvent(string $topicArn, string $message): string
    {
        $messageBody = [
            'Message' => $message,
            'TopicArn' => $topicArn,
        ];
        try {
            $result = $this->awsSnsClient->publish($messageBody);
            var_dump($result);
        } catch (AwsException $e) {
            var_dump($e->getMessage());
        }
    }
}
