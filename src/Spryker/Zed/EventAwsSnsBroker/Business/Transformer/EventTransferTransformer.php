<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Transformer;

use Exception;
use Generated\Shared\Transfer\EventTransfer;
use Spryker\Zed\EventAwsSnsBroker\Business\Exception\MessageNotFoundInEventPayloadException;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

class EventTransferTransformer implements EventTransferTransformerInterface
{
    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig
     */
    protected $eventAwsSnsBrokerConfig;

    /**
     * @param \Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface $utilEncodingService
     * @param \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
     */
    public function __construct(
        EventAwsSnsBrokerToUtilEncodingServiceInterface $utilEncodingService,
        EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
    ) {
        $this->utilEncodingService = $utilEncodingService;
        $this->eventAwsSnsBrokerConfig = $eventAwsSnsBrokerConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\EventTransfer $eventTransfer
     *
     * @throws \Exception
     *
     * @return string
     */
    public function transformEventTransferIntoMessage(EventTransfer $eventTransfer): string
    {
        $message = $this->utilEncodingService->encodeJson($eventTransfer->toArray());

        if ($message) {
            return $message;
        }

        throw new Exception('Transformation EventTransfer into string message is failed.');
    }

    /**
     * @param string $eventMessage
     *
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\MessageNotFoundInEventPayloadException
     *
     * @return \Generated\Shared\Transfer\EventTransfer
     */
    public function transformMessageIntoEventTransfer(string $eventMessage): EventTransfer
    {
        $eventTransferData = (array)$this->utilEncodingService->decodeJson($eventMessage, true);

        if (!isset($eventTransferData['message'])) {
            throw new MessageNotFoundInEventPayloadException('The event doesn\'t contain the \'message\' key.');
        }

        $messageData = $eventTransferData['message'];
        unset($eventTransferData['message']);

        $eventTransfer = (new EventTransfer())->fromArray($eventTransferData);

        $messageTransferClass = $this->eventAwsSnsBrokerConfig
                ->getEventNameToMessageTransferClassNameMap()[$eventTransfer->getEventName()] ?? null;

        if ($messageTransferClass === null) {
            return $eventTransfer;
        }

        /** @var \Spryker\Shared\Kernel\Transfer\TransferInterface $messageTransfer */
        $messageTransfer = new $messageTransferClass();
        $messageTransfer->fromArray($messageData, true);

        $eventTransfer->setMessage($messageTransfer);

        return $eventTransfer;
    }
}
