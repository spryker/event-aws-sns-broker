<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Checker;

class EventNotificationChecker implements EventNotificationCheckerInterface
{
    /**
     * @param mixed[] $requestBody
     * @param mixed[] $requestHeaders
     * @param string $eventBusName
     *
     * @return bool
     */
    public function isEventNotificationCorrect(array $requestBody, array $requestHeaders, string $eventBusName): bool
    {
        // todo::check available event bus for AWS SNS
        // todo::check header
        // todo::header 'x-amz-sns-message-type' should be 'Notification'
        // todo::check request's body

        return true;
    }
}
