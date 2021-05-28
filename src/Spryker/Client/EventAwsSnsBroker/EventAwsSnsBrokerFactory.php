<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker;

use Spryker\Client\EventAwsSnsBroker\ApiClient\AwsSnsApiClient;
use Spryker\Client\EventAwsSnsBroker\ApiClient\AwsSnsApiClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\EventAwsSnsBroker\ApiClient\AwsSnsApiClientInterface
     */
    public function createApiClient(): AwsSnsApiClientInterface
    {
        return new AwsSnsApiClient($this->getConfig());
    }
}
