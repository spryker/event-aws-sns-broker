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
     * @return string
     */
    public function registerSubscriber(string $topicArn, string $endpoint, string $protocol): string
    {
        return $this->getFactory()->createApiClient()->registerSubscriber($topicArn, $endpoint, $protocol);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $topicArn
     * @param string $message
     *
     * @return string
     */
    public function publishEvent(string $topicArn, string $message): string
    {
        return $this->getFactory()->createApiClient()->publishEvent($topicArn, $message);
    }
}
