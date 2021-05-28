<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker\ApiClient;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

class AwsSnsApiClient implements AwsSnsApiClientInterface
{
    /**
     * @var \Aws\Sns\SnsClient
     */
    protected $awsSnsClient;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerConfig $config
     */
    public function __construct(EventAwsSnsBrokerConfig $config)
    {
        $snsConfig = $config->getAwsSnsApiClientConfiguration();

        $this->awsSnsClient = new SnsClient([
            'credentials' => [
                'key' => $snsConfig['access_key'],
                'secret' => $snsConfig['access_secret'],
            ],
            'endpoint' => $snsConfig['endpoint'],
            'region' => $snsConfig['region'],
            'version' => $snsConfig['version'],
        ]);
    }

    /**
     * @param string $topicName
     *
     * @return string
     */
    public function createTopic(string $topicName): string
    {
        // todo
        try {
            $result = $this->awsSnsClient->createTopic([
                'Name' => $topicName,
            ]);

            var_dump($result);

            return $result['TopicArn'];
        } catch (AwsException $e) {
            var_dump($e->getMessage());

            throw $e;
        }
    }

    /**
     * @param string $topicArn
     * @param string $endpoint
     * @param string $protocol
     *
     * @return string
     */
    public function createSubscriber(string $topicArn, string $endpoint, string $protocol): string
    {
        // todo
        try {
            $result = $this->awsSnsClient->subscribe([
                'Protocol' => $protocol,
                'Endpoint' => $endpoint,
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $topicArn,
            ]);
            var_dump($result);

            return $result['SubscriptionArn'];
        } catch (AwsException $e) {
            var_dump($e->getMessage());

            throw $e;
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
        // todo
        $messageBody = [
            'Message' => $message,
            'TopicArn' => $topicArn,
        ];
        try {
            $result = $this->awsSnsClient->publish($messageBody);
            var_dump($result);

            return $result['MessageId'];
        } catch (AwsException $e) {
            var_dump($e->getMessage());

            throw $e;
        }
    }
}
