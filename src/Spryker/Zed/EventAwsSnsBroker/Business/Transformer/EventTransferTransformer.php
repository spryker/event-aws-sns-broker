<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Transformer;

use Exception;
use Generated\Shared\Transfer\EventTransfer;
use RuntimeException;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface;

class EventTransferTransformer implements EventTransferTransformerInterface
{
    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \Spryker\Zed\EventAwsSnsBroker\Dependency\Service\EventAwsSnsBrokerToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(EventAwsSnsBrokerToUtilEncodingServiceInterface $utilEncodingService)
    {
        $this->utilEncodingService = $utilEncodingService;
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
     * @throws \RuntimeException
     *
     * @return \Generated\Shared\Transfer\EventTransfer
     */
    public function transformMessageIntoEventTransfer(string $eventMessage): EventTransfer
    {
        $eventTransferData = $this->utilEncodingService->decodeJson($eventMessage, true);

        if (!isset($eventTransferData['message'])) {
            throw new RuntimeException('The body of the event message doesn\'t contain the \'message\' key.');
        }

        $messageData = $eventTransferData['message'];
        unset($eventTransferData['message']);

        $eventTransfer = (new EventTransfer())->fromArray($eventTransferData);

        $messageTransferClass = $eventTransfer->getMessageTypeOrFail();
        /** @var \Spryker\Shared\Kernel\Transfer\TransferInterface $messageTransfer */
        $messageTransfer = new $messageTransferClass();
        $messageTransfer->fromArray($messageData);

        $eventTransfer->setMessage($messageTransfer);

        return $eventTransfer;
    }
}
