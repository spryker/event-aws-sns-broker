<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Event\EventNotificationChecker;
use Spryker\Zed\EventAwsSnsBroker\Business\Event\EventNotificationCheckerInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Event\EventProcessor;
use Spryker\Zed\EventAwsSnsBroker\Business\Event\EventProcessorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Event\EventPublisher;
use Spryker\Zed\EventAwsSnsBroker\Business\Event\EventPublisherInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Subscriber\SubscriberCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\Subscriber\SubscriberCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Topic\TopicCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\Topic\TopicCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformer;
use Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Event\EventProcessorInterface
     */
    public function createEventProcessor(): EventProcessorInterface
    {
        return new EventProcessor(
            $this->createEventTransferTransformer(),
            $this->getEventFacade()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Topic\TopicCreatorInterface
     */
    public function createTopicCreator(): TopicCreatorInterface
    {
        return new TopicCreator(
            $this->getEventAwsSnsBrokerClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Subscriber\SubscriberCreatorInterface
     */
    public function createSubscriberCreator(): SubscriberCreatorInterface
    {
        return new SubscriberCreator(
            $this->getEventAwsSnsBrokerClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Event\EventPublisherInterface
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
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface
     */
    public function createEventTransferTransformer(): EventTransferTransformerInterface
    {
        return new EventTransferTransformer($this->getUtilEncodingService());
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): EventAwsSnsBrokerToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Event\EventNotificationCheckerInterface
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
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::FACADE_EVENT);
    }
}
