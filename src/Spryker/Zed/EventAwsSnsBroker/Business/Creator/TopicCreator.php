<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Creator;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

class TopicCreator implements TopicCreatorInterface
{
    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig
     */
    protected $eventAwsSnsBrokerConfig;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     * @param \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
     */
    public function __construct(
        EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient,
        EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
    ) {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
        $this->eventAwsSnsBrokerConfig = $eventAwsSnsBrokerConfig;
    }

    /**
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException
     *
     * @return void
     */
    public function createTopics(): void
    {
        $eventBusNames = $this->eventAwsSnsBrokerConfig->getAwsSnsEventBusNames();

        foreach ($eventBusNames as $eventBusName) {
            if (is_numeric($eventBusName)) {
                throw new EventBusNameConfigException();
            }
        }

        /** @var string $eventBusName */
        foreach ($eventBusNames as $eventBusName) {
            $this->eventAwsSnsBrokerClient->createTopic($eventBusName);
        }
    }
}
