<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Generated\Shared\Transfer\EventCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerBusinessFactory getFactory()
 */
class EventAwsSnsBrokerFacade extends AbstractFacade implements EventAwsSnsBrokerFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function createTopics(): void
    {
        $this->getFactory()
            ->createTopicCreator()
            ->createTopics();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function createSubscribers(): void
    {
        $this->getFactory()
            ->createSubscriberCreator()
            ->createSubscribers();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException
     *
     * @return void
     */
    public function publishEvents(EventCollectionTransfer $eventCollectionTransfer): void
    {
        $this->getFactory()
            ->createEventPublisher()
            ->publishEvents($eventCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $eventMessage
     * @param string $eventBusName
     *
     * @return void
     */
    public function handleEvent(string $eventMessage, string $eventBusName): void
    {
        $this->getFactory()
            ->createEventProcessor()
            ->handleEvent($eventMessage, $eventBusName);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param mixed[] $requestBody
     * @param mixed[] $requestHeaders
     * @param string $eventBusName
     *
     * @return bool
     */
    public function isEventNotificationCorrect(array $requestBody, array $requestHeaders, string $eventBusName): bool
    {
        return $this->getFactory()
            ->createEventNotificationChecker()
            ->isEventNotificationCorrect($requestBody, $requestHeaders, $eventBusName);
    }
}
