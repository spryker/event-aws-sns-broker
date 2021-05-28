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
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createTopics(array $eventBusNames): void
    {
        $this->getFactory()
            ->createTopicCreator()
            ->createTopics($eventBusNames);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createSubscribers(array $eventBusNames): void
    {
        $this->getFactory()
            ->createSubscriberCreator()
            ->createSubscribers($eventBusNames);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @return void
     */
    public function publishEvents(EventCollectionTransfer $eventCollectionTransfer): void
    {
        $this->getFactory()
            ->createEventPublisher()
            ->publishEvents($eventCollectionTransfer);
    }
}
