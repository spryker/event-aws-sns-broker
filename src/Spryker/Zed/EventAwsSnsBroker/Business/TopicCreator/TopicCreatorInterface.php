<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\TopicCreator;

interface TopicCreatorInterface
{
    /**
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createTopics(array $eventBusNames): void;
}
