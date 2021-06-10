<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker\ApiClient;

use Aws\Sns\SnsClient;
use Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException;

class AwsSnsApiClient implements AwsSnsApiClientInterface
{
    protected const RESPONSE_TOPIC_ARN_KEY = 'TopicArn';
    protected const RESPONSE_SUBSCRIPTION_ARN_KEY = 'SubscriptionArn';
    protected const RESPONSE_MESSAGE_ID_KEY = 'MessageId';

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
     * @return string
     */
    public function createTopic(string $topicName): string
    {
        $topicBody = [
            'Name' => $topicName,
        ];

        $result = $this->awsSnsClient->createTopic($topicBody);

        if (!isset($result[static::RESPONSE_TOPIC_ARN_KEY])) {
            $this->throwNotExistException('createTopic', static::RESPONSE_TOPIC_ARN_KEY);
        }

        return $result[static::RESPONSE_TOPIC_ARN_KEY];
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
        $subscriptionBody = [
            'Protocol' => $protocol,
            'Endpoint' => $endpoint,
            'ReturnSubscriptionArn' => true,
            'TopicArn' => $topicArn,
        ];

        $result = $this->awsSnsClient->subscribe($subscriptionBody);

        if (!isset($result[static::RESPONSE_SUBSCRIPTION_ARN_KEY])) {
            $this->throwNotExistException('subscribe', static::RESPONSE_SUBSCRIPTION_ARN_KEY);
        }

        return $result[static::RESPONSE_SUBSCRIPTION_ARN_KEY];
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
        $result = $this->awsSnsClient->publish($messageBody);

        if (!isset($result[static::RESPONSE_MESSAGE_ID_KEY])) {
            $this->throwNotExistException('publish', static::RESPONSE_MESSAGE_ID_KEY);
        }

        return $result[static::RESPONSE_MESSAGE_ID_KEY];
    }

    /**
     * @param string $methodName
     * @param string $notExistedKeyName
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return void
     */
    public function throwNotExistException(string $methodName, string $notExistedKeyName): void
    {
        throw new AwsSnsClientResponseException(sprintf(
            "The response of the '%s' request doesn't contain the '%s' key.",
            $methodName,
            $notExistedKeyName
        ));
    }
}
