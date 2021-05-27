<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator;

use Spryker\Zed\EventAwsSnsBroker\Business\ApiClient\EventAwsSnsApiClientInterface;

class TopicCreator implements TopicCreatorInterface
{
    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Business\ApiClient\EventAwsSnsApiClientInterface
     */
    protected $eventAwsSnsBrokerApiClient;

    /**
     * @param \Spryker\Zed\EventAwsSnsBroker\Business\ApiClient\EventAwsSnsApiClientInterface $eventAwsSnsBrokerApiClient
     */
    public function __construct(EventAwsSnsApiClientInterface $eventAwsSnsBrokerApiClient)
    {
        $this->eventAwsSnsBrokerApiClient = $eventAwsSnsBrokerApiClient;
    }

    /**
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createTopics(array $eventBusNames): void
    {
        foreach ($eventBusNames as $eventBusName) {
            $topicArn = $this->eventAwsSnsBrokerApiClient->createTopic($eventBusName);
            // todo::save $topicArn into BD
        }
    }
}
