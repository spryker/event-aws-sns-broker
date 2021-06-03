<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker;

use Spryker\Client\Kernel\AbstractBundleConfig;
use Spryker\Shared\EventAwsSnsBroker\EventAwsSnsBrokerConstants;

class EventAwsSnsBrokerConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Returns array of configurations for SNS API client.
     *
     * @api
     *
     * @return string[]
     */
    public function getAwsSnsApiClientConfiguration(): array
    {
        $configs = $this->get(EventAwsSnsBrokerConstants::EVENT_AWS_SNS_BROKER_CONFIG);

        return [
            'accessKey' => $configs[EventAwsSnsBrokerConstants::AWS_SNS_ACCESS_KEY],
            'accessSecret' => $configs[EventAwsSnsBrokerConstants::AWS_SNS_ACCESS_SECRET],
            'region' => $configs[EventAwsSnsBrokerConstants::AWS_SNS_REGION],
            'endpoint' => $configs[EventAwsSnsBrokerConstants::AWS_SNS_ENDPOINT],
            'version' => $configs[EventAwsSnsBrokerConstants::AWS_SNS_VERSION],
        ];
    }
}
