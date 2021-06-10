<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Event;

interface EventProcessorInterface
{
    /**
     * @param string $eventMessage
     * @param string $eventBusName
     *
     * @return void
     */
    public function handleEvent(string $eventMessage, string $eventBusName): void;
}
