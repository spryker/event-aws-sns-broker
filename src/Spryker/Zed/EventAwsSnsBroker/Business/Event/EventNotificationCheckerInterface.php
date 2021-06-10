<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Event;

interface EventNotificationCheckerInterface
{
    /**
     * @param mixed[] $requestBody
     * @param mixed[] $requestHeaders
     * @param string $eventBusName
     *
     * @return bool
     */
    public function isEventNotificationCorrect(array $requestBody, array $requestHeaders, string $eventBusName): bool;
}
