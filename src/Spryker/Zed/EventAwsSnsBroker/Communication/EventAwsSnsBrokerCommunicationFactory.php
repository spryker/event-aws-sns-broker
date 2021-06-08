<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Communication;

use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface getFacade()
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    public function getUtilEncoding()
    {
        return $this->getProvidedDependency(EventAwsSnsBrokerDependencyProvider::SERVICE_ENCODING);
    }
}
