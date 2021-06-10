<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Communication\Plugin;

use Generated\Shared\Transfer\EventCollectionTransfer;
use Spryker\Shared\EventExtension\Dependency\Plugin\EventBrokerPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface getFacade()
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerBusinessFactory getFactory()
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerEventBrokerPlugin extends AbstractPlugin implements EventBrokerPluginInterface
{
    /**
     * {@inheritDoc}
     * - Transits events to the AWS SNS Broker.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException
     *
     * @return void
     */
    public function putEvents(EventCollectionTransfer $eventCollectionTransfer): void
    {
        $this->getFacade()->publishEvents($eventCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     * - Returns true if requested `eventBusName` is registered in configs.
     *
     * @api
     *
     * @param string $eventBusName
     *
     * @return bool
     */
    public function isApplicable(string $eventBusName): bool
    {
        return in_array($eventBusName, $this->getConfig()->getAwsSnsEventBusNames(), true);
    }
}
