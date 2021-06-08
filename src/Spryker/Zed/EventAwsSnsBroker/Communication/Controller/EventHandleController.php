<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface getFacade()
 * @method \Spryker\Zed\EventAwsSnsBroker\Communication\EventAwsSnsBrokerCommunicationFactory getFactory()
 */
class EventHandleController extends AbstractController
{
    public const QUERY_PARAM_EVENT_BUS_NAME = 'event-bus-name';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request): Response
    {
        /** @var string $eventBusName */
        $eventBusName = $request->query->get(static::QUERY_PARAM_EVENT_BUS_NAME) ?? '';

        if (!is_string($request->getContent())) {
            return new Response('Resource is unexpected.', Response::HTTP_BAD_REQUEST);
        }

        /** @var mixed[] $data */
        $data = $this->getFactory()->getUtilEncoding()->decodeJson($request->getContent(), true);

        if (!$this->getFacade()->isEventNotificationCorrect($data, $request->headers->all(), $eventBusName)) {
            return new Response('Received data is not supported.', Response::HTTP_BAD_REQUEST);
        }

        $this->getFacade()->handleEvent(
            $data['Message'],
            $eventBusName
        );

        return new Response('', Response::HTTP_CREATED);
    }
}
