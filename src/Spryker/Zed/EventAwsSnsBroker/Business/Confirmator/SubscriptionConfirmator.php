<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Confirmator;

use Generated\Shared\Transfer\SubscriptionConfirmationTransfer;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

class SubscriptionConfirmator implements SubscriptionConfirmatorInterface
{
    protected const REQUEST_TOPIC_ARN_FIELD = 'TopicArn';
    protected const REQUEST_TOKEN_FIELD = 'Token';

    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig
     */
    protected $eventAwsSnsBrokerConfig;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     * @param \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
     */
    public function __construct(
        EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient,
        EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
    ) {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
        $this->eventAwsSnsBrokerConfig = $eventAwsSnsBrokerConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\SubscriptionConfirmationTransfer $subscriptionConfirmationTransfer
     *
     * @return bool
     */
    public function confirmSubscription(SubscriptionConfirmationTransfer $subscriptionConfirmationTransfer): bool
    {
        $this->checkRequiredDataExisted($subscriptionConfirmationTransfer);

        if (!in_array($subscriptionConfirmationTransfer->getTopicArnOrFail(), $this->eventAwsSnsBrokerConfig->getEventBusNameToAwsSnsTopicArnMap())) {
            return false;
        }

        $this->eventAwsSnsBrokerClient
            ->confirmSubscription(
                $subscriptionConfirmationTransfer->getTopicArnOrFail(),
                $subscriptionConfirmationTransfer->getTokenOrFail()
            );

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\SubscriptionConfirmationTransfer $subscriptionConfirmationTransfer
     *
     * @return void
     */
    protected function checkRequiredDataExisted(SubscriptionConfirmationTransfer $subscriptionConfirmationTransfer): void
    {
        $subscriptionConfirmationTransfer->requireToken()->requireTopicArn();
    }
}
