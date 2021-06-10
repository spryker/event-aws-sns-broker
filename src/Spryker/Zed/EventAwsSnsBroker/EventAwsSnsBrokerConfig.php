<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\EventAwsSnsBroker\EventAwsSnsBrokerConstants;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class EventAwsSnsBrokerConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Returns map of topic ARNs with event bus names registered in the config.
     *
     * @api
     *
     * @return string[]
     */
    public function getAwsSnsTopicArnMappedWithEventBusNames(): array
    {
        return $this->get(EventAwsSnsBrokerConstants::AWS_SNS_BUS_NAMES_TOPIC_ARN, []);
    }

    /**
     * Specification:
     * - Returns list of event bus names registered in the config.
     *
     * @api
     *
     * @phpstan-return array<int, string>
     *
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException
     *
     * @return string[]
     */
    public function getAwsSnsEventBusNames(): array
    {
        $topicNameEventBusNameMap = $this->get(EventAwsSnsBrokerConstants::AWS_SNS_BUS_NAMES_TOPIC_ARN, []);

        $eventBusNames = array_keys($topicNameEventBusNameMap);

        foreach ($eventBusNames as $eventBusName) {
            if (is_numeric($eventBusName)) {
                throw new EventBusNameConfigException();
            }
        }

        return $eventBusNames;
    }

    /**
     * Specification:
     * - Returns base url of ZED.
     *
     * @api
     *
     * @return string
     */
    public function getZedRequestBaseUrl(): string
    {
        return $this->getConfig()->get(ApplicationConstants::BASE_URL_ZED);
    }

    /**
     * Specification:
     * - Returns one of supported protocols of SNS.
     *
     * @api
     *
     * @return string
     */
    public function getAwsSnsProtocol(): string
    {
        return $this->getConfig()->get(RouterConstants::ZED_IS_SSL_ENABLED)
            ? 'https'
            : 'http';
    }
}
