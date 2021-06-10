<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Transformer;

use Generated\Shared\Transfer\EventTransfer;

interface EventTransferTransformerInterface
{
    /**
     * @param \Generated\Shared\Transfer\EventTransfer $eventTransfer
     *
     * @return string
     */
    public function transformEventTransferIntoMessage(EventTransfer $eventTransfer): string;

    /**
     * @param string $eventMessage
     *
     * @return \Generated\Shared\Transfer\EventTransfer
     */
    public function transformMessageIntoEventTransfer(string $eventMessage): EventTransfer;
}
