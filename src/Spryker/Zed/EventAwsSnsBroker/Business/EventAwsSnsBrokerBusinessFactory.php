<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return void
     */
    public function createEventHandler()
    {
    }

    /**
     * @return void
     */
    public function createAwsSnsApiClient()
    {
    }
}
