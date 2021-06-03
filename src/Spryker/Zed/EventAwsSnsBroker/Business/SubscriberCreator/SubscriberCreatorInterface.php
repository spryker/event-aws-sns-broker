<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator;

interface SubscriberCreatorInterface
{
    /**
     * @param string[] $eventBusNameTopicArnMap
     *
     * @return void
     */
    public function createSubscribers(array $eventBusNameTopicArnMap): void;
}
