<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Checker\EventNotificationChecker;
use Spryker\Zed\EventAwsSnsBroker\Business\Checker\EventNotificationCheckerInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Creator\SubscriberCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\Creator\SubscriberCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Creator\TopicCreator;
use Spryker\Zed\EventAwsSnsBroker\Business\Creator\TopicCreatorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Processor\EventProcessor;
use Spryker\Zed\EventAwsSnsBroker\Business\Processor\EventProcessorInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\Publisher\EventPublisher;
use Spryker\Zed\EventAwsSnsBroker\Business\Publisher\EventPublisherInterface;
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
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Processor\EventProcessorInterface
     */
    public function createEventProcessor(): EventProcessorInterface
    {
        return new EventProcessor(
            $this->createEventTransferTransformer(),
            $this->getEventFacade()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Creator\TopicCreatorInterface
     */
    public function createTopicCreator(): TopicCreatorInterface
    {
        return new TopicCreator(
            $this->getEventAwsSnsBrokerClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Creator\SubscriberCreatorInterface
     */
    public function createSubscriberCreator(): SubscriberCreatorInterface
    {
        return new SubscriberCreator(
            $this->getEventAwsSnsBrokerClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Publisher\EventPublisherInterface
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
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\Checker\EventNotificationCheckerInterface
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
