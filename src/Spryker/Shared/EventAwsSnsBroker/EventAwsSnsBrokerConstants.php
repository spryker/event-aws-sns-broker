<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\EventAwsSnsBroker;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface EventAwsSnsBrokerConstants
{
    /**
     * Specification:
     * - Contains configurations value for module.
     *
     * @api
     */
    public const EVENT_AWS_SNS_BROKER_CONFIG = 'EVENT_AWS_SNS_BROKER:EVENT_AWS_SNS_BROKER_CONFIG';

    /**
     * Specification:
     * - Contains AWS access key used for SNS.
     *
     * @api
     */
    public const AWS_SNS_ACCESS_KEY = 'EVENT_AWS_SNS_BROKER:AWS_SNS_ACCESS_KEY';

    /**
     * Specification:
     * - Contains AWS secret used for SNS.
     *
     * @api
     */
    public const AWS_SNS_ACCESS_SECRET = 'EVENT_AWS_SNS_BROKER:AWS_SNS_ACCESS_SECRET';

    /**
     * Specification:
     * - Contains AWS region used for SNS.
     *
     * @api
     */
    public const AWS_SNS_REGION = 'EVENT_AWS_SNS_BROKER:AWS_SNS_REGION';

    /**
     * Specification:
     * - Contains AWS SNS api endpoint.
     *
     * @api
     */
    public const AWS_SNS_ENDPOINT = 'EVENT_AWS_SNS_BROKER:AWS_SNS_ENDPOINT';

    /**
     * Specification:
     * - Contains AWS SNS api version.
     *
     * @api
     */
    public const AWS_SNS_VERSION = 'EVENT_AWS_SNS_BROKER:AWS_SNS_VERSION';

    public const AWS_SNS_BUS_NAMES = 'EVENT_AWS_SNS_BROKER:AWS_SNS_BUS_NAMES';
}
