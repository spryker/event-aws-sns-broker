<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Generated\Shared\Transfer\EventCollectionTransfer;

interface EventAwsSnsBrokerFacadeInterface
{
    /**
     * Specification:
     * - Calls the AWS SNS client's method to create topics (EventBuses).
     *
     * @api
     *
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createTopics(array $eventBusNames): void;

    /**
     * Specification:
     * - Calls the AWS SNS client's method to register subscribers with event busses' names.
     * - Subscriber - this is action of the handler controller that receive events from the AWS SNS broker.
     * - Saves subscriberArn into BD.
     *
     * @api
     *
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createSubscribers(array $eventBusNames): void;

    /**
     * Specification:
     * - Calls the AWS SNS client's method to publish events for broker.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @return void
     */
    public function publishEvents(EventCollectionTransfer $eventCollectionTransfer): void;
}
