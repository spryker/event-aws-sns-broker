<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class EventAwsSnsBrokerConfig extends AbstractBundleConfig
{
    public const EVENT_AWS_SNS_BUS_NAMES = 'EVENT_AWS_SNS_BUS_NAMES';

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
        $busses = $this->get('blabla', [static::EVENT_AWS_SNS_BUS_NAMES => ['test_topicName']]);

        return $busses[static::EVENT_AWS_SNS_BUS_NAMES] ?? [];
    }
}
