<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerFactory getFactory()
 */
class EventAwsSnsBrokerClient extends AbstractClient implements EventAwsSnsBrokerClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $topicName
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function createTopic(string $topicName): string
    {
        return $this->getFactory()->createApiClient()->createTopic($topicName);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $topicArn
     * @param string $endpoint
     * @param string $protocol
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function createSubscriber(string $topicArn, string $endpoint, string $protocol): string
    {
        return $this->getFactory()->createApiClient()->createSubscriber($topicArn, $endpoint, $protocol);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $topicArn
     * @param string $token
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function confirmSubscription(string $topicArn, string $token): string
    {
        return $this->getFactory()->createApiClient()->confirmSubscription($topicArn, $token);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $topicArn
     * @param string $message
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function publishEvent(string $topicArn, string $message): string
    {
        return $this->getFactory()->createApiClient()->publishEvent($topicArn, $message);
    }
}
