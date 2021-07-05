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
     * @return void
     */
    public function createTopics(): void;

    /**
     * Specification:
     * - Calls the AWS SNS client's method to register subscribers with event busses' names.
     * - Subscriber - this is action of the handler controller that receive events from the AWS SNS broker.
     *
     * @api
     *
     * @return void
     */
    public function createSubscribers(): void;

    /**
     * Specification:
     * - Calls the AWS SNS client's method to publish events for broker.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException
     *
     * @return void
     */
    public function publishEvents(EventCollectionTransfer $eventCollectionTransfer): void;

    /**
     * Specification:
     * - Process an received event from AWS SNS through HTTP(S).
     *
     * @api
     *
     * @param string $eventMessage
     * @param string $eventBusName
     *
     * @return void
     */
    public function dispatchEvent(string $eventMessage, string $eventBusName): void;
}
