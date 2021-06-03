<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker;

use Aws\Sns\SnsClient;
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
        return new AwsSnsApiClient($this->createSnsClient());
    }

    /**
     * @return \Aws\Sns\SnsClient
     */
    public function createSnsClient(): SnsClient
    {
        $snsConfig = $this->getConfig()->getAwsSnsApiClientConfiguration();

        $awsSnsClient = new SnsClient([
            'credentials' => [
                'key' => $snsConfig['accessKey'],
                'secret' => $snsConfig['accessSecret'],
            ],
            'endpoint' => $snsConfig['endpoint'],
            'region' => $snsConfig['region'],
            'version' => $snsConfig['version'],
        ]);

        return $awsSnsClient;
    }
}
