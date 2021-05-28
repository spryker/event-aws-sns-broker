<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher\EventPublisher;
use Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher\EventPublisherInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformer;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator\SubscriberCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator\SubscriberCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return void
     */
    public function createEventHandler(): void
    {
        // todo

        return;
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreatorInterface
     */
    public function createTopicCreator(): TopicCreatorInterface
    {
        return new TopicCreator($this->getEventAwsSnsBrokerClient());
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator\SubscriberCreatorInterface
     */
    public function createSubscriberCreator(): SubscriberCreatorInterface
    {
        return new SubscriberCreator($this->getEventAwsSnsBrokerClient());
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher\EventPublisherInterface
     */
    public function createEventPublisher(): EventPublisherInterface
    {
        return new EventPublisher(
            $this->getEventAwsSnsBrokerClient(),
            $this->createEventTransferTransformer()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface
     */
    public function createEventTransferTransformer(): EventTransferTransformerInterface
    {
        return new EventTransferTransformer();
    }

    /**
     * @return \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    public function getEventAwsSnsBrokerClient(): EventAwsSnsBrokerClientInterface
    {
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER);
    }
}
