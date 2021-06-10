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
use Spryker\Shared\EventAwsSnsBroker\EventAwsSnsBrokerConstants;

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
        $awsSnsApiClientConfigurations = $this->getConfig()->getAwsSnsApiClientConfigurations();

        return new SnsClient([
            'credentials' => [
                'key' => $awsSnsApiClientConfigurations[EventAwsSnsBrokerConstants::AWS_SNS_ACCESS_KEY],
                'secret' => $awsSnsApiClientConfigurations[EventAwsSnsBrokerConstants::AWS_SNS_ACCESS_SECRET],
            ],
            'endpoint' => $awsSnsApiClientConfigurations[EventAwsSnsBrokerConstants::AWS_SNS_ENDPOINT],
            'region' => $awsSnsApiClientConfigurations[EventAwsSnsBrokerConstants::AWS_SNS_REGION],
            'version' => $awsSnsApiClientConfigurations[EventAwsSnsBrokerConstants::AWS_SNS_VERSION],
        ]);
    }
}
