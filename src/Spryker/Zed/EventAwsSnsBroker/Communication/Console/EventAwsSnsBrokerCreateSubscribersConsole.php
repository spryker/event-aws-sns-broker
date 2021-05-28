<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface getFacade()
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerBusinessFactory getFactory()
 */
class EventAwsSnsBrokerCreateSubscribersConsole extends Console
{
    public const COMMAND_NAME = 'event-broker:aws-sns:create-subscribers';
    public const DESCRIPTION = 'This command creates subscribers basing on event bus names from config.';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->createSubscribers($this->getFactory()->getConfig()->getAwsSnsEventBusNames());

        return static::CODE_SUCCESS;
    }
}
