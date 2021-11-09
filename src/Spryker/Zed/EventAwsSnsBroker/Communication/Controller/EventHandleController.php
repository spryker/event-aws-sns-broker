<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Communication\Controller;

use Generated\Shared\Transfer\SubscriptionConfirmationTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface getFacade()
 * @method \Spryker\Zed\EventAwsSnsBroker\Communication\EventAwsSnsBrokerCommunicationFactory getFactory()
 */
class EventHandleController extends AbstractController
{
    /**
     * @var string
     */
    public const QUERY_PARAM_EVENT_BUS_NAME = 'event-bus-name';

    /**
     * @var string
     */
    protected const AWS_SNS_REQUEST_TYPE_FIELD = 'Type';

    /**
     * @var string
     */
    protected const AWS_SNS_REQUEST_TYPE_SUBSCRIPTION_CONFIRMATION = 'SubscriptionConfirmation';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request): Response
    {
        if (!$request->getContent()) {
            return new Response('Resource is unexpected.', Response::HTTP_BAD_REQUEST);
        }

        $requestData = $this->getFactory()
            ->getUtilEncodingService()
            ->decodeJson($request->getContent(), true);

        if (
            isset($requestData[static::AWS_SNS_REQUEST_TYPE_FIELD])
            && $requestData[static::AWS_SNS_REQUEST_TYPE_FIELD] === static::AWS_SNS_REQUEST_TYPE_SUBSCRIPTION_CONFIRMATION
        ) {
            return $this->handleSubscriptionConfirmation($requestData);
        }

        return $this->handleEventMessage($request, $requestData);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $requestData
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleEventMessage(Request $request, array $requestData): Response
    {
        /** @var string $eventBusName */
        $eventBusName = $request->query->get(static::QUERY_PARAM_EVENT_BUS_NAME) ?? '';

        $this->getFacade()->dispatchEvent(
            $requestData['Message'],
            $eventBusName,
        );

        return new Response('The event is processed.', Response::HTTP_CREATED);
    }

    /**
     * @param array $requestData
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleSubscriptionConfirmation(array $requestData): Response
    {
        $subscriptionConfirmationTransfer = (new SubscriptionConfirmationTransfer())->fromArray($requestData, true);
        $result = $this->getFacade()->confirmSubscription($subscriptionConfirmationTransfer);

        return $result
            ? new Response('The subscription is confirmed.', Response::HTTP_OK)
            : new Response('The subscription is not confirmed.', Response::HTTP_BAD_REQUEST);
    }
}
