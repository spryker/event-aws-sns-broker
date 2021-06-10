<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Subscriber;

interface SubscriberCreatorInterface
{
    /**
     * @throws \Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException
     *
     * @return void
     */
    public function createSubscribers(): void;
}
