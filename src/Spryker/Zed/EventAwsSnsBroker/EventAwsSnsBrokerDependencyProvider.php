<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker;

use Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig getConfig()
 */
class EventAwsSnsBrokerDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_EVENT_AWS_SNS_BROKER = 'CLIENT_EVENT_AWS_SNS_BROKER';
    public const EVENT_FACADE = 'EVENT_FACADE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addEventAwsSnsBrokerClient($container);
        $container = $this->addEventFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventAwsSnsBrokerClient(Container $container): Container
    {
        $container->set(static::CLIENT_EVENT_AWS_SNS_BROKER, function (Container $container) {
            return $container->getLocator()->eventAwsSnsBroker()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container): Container
    {
        $container->set(static::EVENT_FACADE, function (Container $container) {
            return new EventAwsSnsBrokerToEventFacadeBridge($container->getLocator()->event()->facade());
        });

        return $container;
    }
}
