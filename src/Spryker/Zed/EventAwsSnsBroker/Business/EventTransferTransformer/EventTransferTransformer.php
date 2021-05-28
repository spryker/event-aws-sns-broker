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
     * @return string
     */
    public function transformEventTransferIntoMessage(EventTransfer $eventTransfer): string
    {
        $message = json_encode($eventTransfer);

        if ($message) {
            return $message;
        }

        throw new Exception('Transformation EventTransfer into string message is failed.');
    }

    /**
     * @param string $message
     *
     * @return \Generated\Shared\Transfer\EventTransfer
     */
    public function transformMessageIntoEventTransfer(string $message): EventTransfer
    {
        // todo::implement it with handler
        return new EventTransfer();
    }
}
