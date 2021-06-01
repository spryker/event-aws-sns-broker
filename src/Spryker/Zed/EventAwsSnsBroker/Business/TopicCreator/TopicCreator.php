<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;

class TopicCreator implements TopicCreatorInterface
{
    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     */
    public function __construct(EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient)
    {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
    }

    /**
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createTopics(array $eventBusNames): void
    {
        foreach ($eventBusNames as $eventBusName) {
            $this->eventAwsSnsBrokerClient->createTopic($eventBusName);
        }
    }
}
