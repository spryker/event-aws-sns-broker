<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Spryker\Zed\EventAwsSnsBroker\Business\ApiClient\AwsSnsApiClient;
use Spryker\Zed\EventAwsSnsBroker\Business\ApiClient\EventAwsSnsApiClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreatorInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return void
     */
    public function createEventHandler()
    {
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreatorInterface
     */
    public function createTopicCreator(): TopicCreatorInterface
    {
        return new TopicCreator($this->createApiClient());
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\ApiClient\EventAwsSnsApiClientInterface
     */
    public function createApiClient(): EventAwsSnsApiClientInterface
    {
        // todo::pass config of credentials
        return new AwsSnsApiClient();
    }

    /**
     * @return string[]
     */
    public function getBusNames(): array
    {
        return $this->getConfig()->getAwsSnsEventBusNames();
    }
}
