<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker\ApiClient;

interface AwsSnsApiClientInterface
{
    /**
     * @param string $topicName
     *
     * @return string
     */
    public function createTopic(string $topicName): string;

    /**
     * @param string $topicArn
     * @param string $endpoint
     * @param string $protocol
     *
     * @return string
     */
    public function registerSubscriber(string $topicArn, string $endpoint, string $protocol): string;

    /**
     * @param string $topicArn
     * @param string $message
     *
     * @return string
     */
    public function publishEvent(string $topicArn, string $message): string;
}
