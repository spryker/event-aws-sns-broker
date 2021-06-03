<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker\ApiClient;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Exception;
use RuntimeException;
use Spryker\Shared\ErrorHandler\ErrorLogger;

class AwsSnsApiClient implements AwsSnsApiClientInterface
{
    /**
     * @var \Aws\Sns\SnsClient
     */
    protected $awsSnsClient;

    /**
     * @param \Aws\Sns\SnsClient $snsClient
     */
    public function __construct(SnsClient $snsClient)
    {
        $this->awsSnsClient = $snsClient;
    }

    /**
     * @param string $topicName
     *
     * @throws \RuntimeException
     *
     * @return string|null
     */
    public function createTopic(string $topicName): ?string
    {
        try {
            $topicBody = [
                'Name' => $topicName,
            ];

            $result = $this->awsSnsClient->createTopic($topicBody);

            if (!isset($result['TopicArn'])) {
                throw new RuntimeException('The response of the "createTopic" request doesn\'t contain the "TopicArn" key.');
            }

            return $result['TopicArn'];
        } catch (AwsException $exception) {
        } catch (RuntimeException $exception) {
        }

        $this->logException($exception);

        return null;
    }

    /**
     * @param string $topicArn
     * @param string $endpoint
     * @param string $protocol
     *
     * @throws \RuntimeException
     *
     * @return string|null
     */
    public function createSubscriber(string $topicArn, string $endpoint, string $protocol): ?string
    {
        try {
            $subscriptionBody = [
                'Protocol' => $protocol,
                'Endpoint' => $endpoint,
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $topicArn,
            ];

            $result = $this->awsSnsClient->subscribe($subscriptionBody);

            if (!isset($result['SubscriptionArn'])) {
                throw new RuntimeException('The response of the "subscribe" request doesn\'t contain the "SubscriptionArn" key.');
            }

            return $result['SubscriptionArn'];
        } catch (AwsException $exception) {
        } catch (RuntimeException $exception) {
        }

        $this->logException($exception);

        return null;
    }

    /**
     * @param string $topicArn
     * @param string $message
     *
     * @throws \RuntimeException
     *
     * @return string|null
     */
    public function publishEvent(string $topicArn, string $message): ?string
    {
        try {
            $messageBody = [
                'Message' => $message,
                'TopicArn' => $topicArn,
            ];
            $result = $this->awsSnsClient->publish($messageBody);

            if (!isset($result['MessageId'])) {
                throw new RuntimeException('The response of the "publish" request doesn\'t contain the "MessageId" key.');
            }

            return $result['MessageId'];
        } catch (AwsException $exception) {
        } catch (RuntimeException $exception) {
        }

        $this->logException($exception);

        return null;
    }

    /**
     * @param \Exception $exception
     *
     * @return void
     */
    protected function logException(Exception $exception): void
    {
        ErrorLogger::getInstance()->log($exception);
    }
}
