<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventHandler\EventHandler;
use Spryker\Zed\EventAwsSnsBroker\Business\EventHandler\EventHandlerInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventNotificationChecker\EventNotificationChecker;
use Spryker\Zed\EventAwsSnsBroker\Business\EventNotificationChecker\EventNotificationCheckerInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher\EventPublisher;
use Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher\EventPublisherInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformer;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator\SubscriberCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator\SubscriberCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator\TopicCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventHandler\EventHandlerInterface
     */
    public function createEventHandler(): EventHandlerInterface
    {
        return new EventHandler(
            $this->createEventTransferTransformer(),
            $this->getEventFacade()
        );
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
        return new SubscriberCreator(
            $this->getEventAwsSnsBrokerClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher\EventPublisherInterface
     */
    public function createEventPublisher(): EventPublisherInterface
    {
        return new EventPublisher(
            $this->getEventAwsSnsBrokerClient(),
            $this->createEventTransferTransformer(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface
     */
    public function createEventTransferTransformer(): EventTransferTransformerInterface
    {
        return new EventTransferTransformer($this->getUtilEncoding());
    }

    /**
     * @return \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    public function getUtilEncoding()
    {
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::SERVICE_ENCODING);
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventNotificationChecker\EventNotificationCheckerInterface
     */
    public function createEventNotificationChecker(): EventNotificationCheckerInterface
    {
        return new EventNotificationChecker();
    }

    /**
     * @return \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    public function getEventAwsSnsBrokerClient(): EventAwsSnsBrokerClientInterface
    {
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER);
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface
     */
    public function getEventFacade(): EventAwsSnsBrokerToEventFacadeInterface
    {
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::EVENT_FACADE);
    }
}
