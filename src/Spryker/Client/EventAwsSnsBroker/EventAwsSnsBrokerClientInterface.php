<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\EventAwsSnsBroker;

interface EventAwsSnsBrokerClientInterface
{
    /**
     * Specification:
     * - Requests the AWS SNS API to create topic.
     *
     * @api
     *
     * @param string $topicName
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function createTopic(string $topicName): string;

    /**
     * Specification:
     * - Requests the AWS SNS API to register subscribers for specific topic.
     *
     * @api
     *
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
     * Specification:
     * - Requests the AWS SNS API to publish event.
     *
     * @api
     *
     * @param string $topicArn
     * @param string $message
     *
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return string
     */
    public function publishEvent(string $topicArn, string $message): string;
}
