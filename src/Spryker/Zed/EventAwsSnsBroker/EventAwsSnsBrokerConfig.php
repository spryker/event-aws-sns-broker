<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker;

use Spryker\Shared\EventAwsSnsBroker\EventAwsSnsBrokerConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
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
     * @return string[]
     */
    public function getAwsSnsEventBusNames(): array
    {
        $topicNameEventBusNameMap = $this->get(EventAwsSnsBrokerConstants::AWS_SNS_BUS_NAMES_TOPIC_ARN, []);

        return array_filter(array_keys($topicNameEventBusNameMap), function ($key): bool {
            return is_string($key);
        });
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
        return $this->getConfig()->get(ZedRequestConstants::ZED_API_SSL_ENABLED)
            ? $this->getConfig()->get(ZedRequestConstants::BASE_URL_SSL_ZED_API)
            : $this->getConfig()->get(ZedRequestConstants::BASE_URL_ZED_API);
    }

    /**
     * Specification:
     * - Returns one of supported protocols of sns.
     *
     * @api
     *
     * @return string
     */
    public function getAwsSnsProtocol(): string
    {
        return $this->getConfig()->get(ZedRequestConstants::ZED_API_SSL_ENABLED)
            ? 'https'
            : 'http';
    }
}
