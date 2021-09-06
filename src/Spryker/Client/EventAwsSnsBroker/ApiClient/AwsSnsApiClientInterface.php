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
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function createTopic(string $topicName): string;

    /**
     * @param string $topicArn
     * @param string $endpoint
     * @param string $protocol
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function createSubscriber(string $topicArn, string $endpoint, string $protocol): string;

    /**
     * @param string $topicArn
     * @param string $token
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function confirmSubscription(string $topicArn, string $token): string;

    /**
     * @param string $topicArn
     * @param string $message
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function publishEvent(string $topicArn, string $message): string;
}
