<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer;

use Exception;
use Generated\Shared\Transfer\EventTransfer;

class EventTransferTransformer implements EventTransferTransformerInterface
{
    /**
     * @param \Generated\Shared\Transfer\EventTransfer $eventTransfer
     *
     * @throws \Exception
     *
     * @return string
     */
    public function transformEventTransferIntoMessage(EventTransfer $eventTransfer): string
    {
        $message = json_encode($eventTransfer->toArray());

        if ($message) {
            return $message;
        }

        throw new Exception('Transformation EventTransfer into string message is failed.');
    }

    /**
     * @param string $eventMessage
     *
     * @return \Generated\Shared\Transfer\EventTransfer
     */
    public function transformMessageIntoEventTransfer(string $eventMessage): EventTransfer
    {
        $eventTransferData = json_decode($eventMessage, true);
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
