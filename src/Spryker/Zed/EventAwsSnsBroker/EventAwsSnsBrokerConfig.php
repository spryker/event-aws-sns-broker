<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker;

use Spryker\Shared\EventAwsSnsBroker\EventAwsSnsBrokerConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class EventAwsSnsBrokerConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Returns list of event bus names registered in config files.
     *
     * @api
     *
     * @return string[]
     */
    public function getAwsSnsEventBusNames(): array
    {
        return $this->get(EventAwsSnsBrokerConstants::AWS_SNS_BUS_NAMES, []);
    }
}
