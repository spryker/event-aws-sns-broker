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
     * - Defines configurations value for module.
     *
     * @api
     *
     * @var string
     */
    public const EVENT_AWS_SNS_BROKER_CONFIG = 'EVENT_AWS_SNS_BROKER:EVENT_AWS_SNS_BROKER_CONFIG';

    /**
     * Specification:
     * - Defines AWS access key used for SNS.
     *
     * @api
     *
     * @var string
     */
    public const AWS_SNS_ACCESS_KEY = 'EVENT_AWS_SNS_BROKER:AWS_SNS_ACCESS_KEY';

    /**
     * Specification:
     * - Defines AWS secret used for SNS.
     *
     * @api
     *
     * @var string
     */
    public const AWS_SNS_ACCESS_SECRET = 'EVENT_AWS_SNS_BROKER:AWS_SNS_ACCESS_SECRET';

    /**
     * Specification:
     * - Defines AWS region used for SNS.
     *
     * @api
     *
     * @var string
     */
    public const AWS_SNS_REGION = 'EVENT_AWS_SNS_BROKER:AWS_SNS_REGION';

    /**
     * Specification:
     * - Defines AWS SNS api endpoint.
     *
     * @api
     *
     * @var string
     */
    public const AWS_SNS_ENDPOINT = 'EVENT_AWS_SNS_BROKER:AWS_SNS_ENDPOINT';

    /**
     * Specification:
     * - Defines AWS SNS api version.
     *
     * @api
     *
     * @var string
     */
    public const AWS_SNS_VERSION = 'EVENT_AWS_SNS_BROKER:AWS_SNS_VERSION';

    /**
     * Specification:
     * - Defines AWS SNS topic ARNs mapped with event bus name.
     *
     * @api
     *
     * @var string
     */
    public const AWS_SNS_BUS_NAMES_TOPIC_ARN = 'EVENT_AWS_SNS_BROKER:AWS_SNS_BUS_NAMES_TOPIC_ARN';
}
