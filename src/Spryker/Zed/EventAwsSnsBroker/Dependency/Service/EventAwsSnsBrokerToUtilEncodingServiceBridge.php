<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Dependency\Service;

class EventAwsSnsBrokerToUtilEncodingServiceBridge implements EventAwsSnsBrokerToUtilEncodingServiceInterface
{
    /**
     * @var \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct($utilEncodingService)
    {
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param string $jsonValue
     * @param bool $assoc
     * @param int|null $depth
     * @param int|null $options
     *
     * @return array|null
     */
    public function decodeJson(string $jsonValue, bool $assoc = false, ?int $depth = null, ?int $options = null): ?array
    {
        if ($assoc === false) {
            trigger_error(
                'Param #2 `$assoc` must be `true` as return of type `object` is not accepted.',
                E_USER_DEPRECATED
            );
        }
 
        return $this->utilEncodingService->decodeJson($jsonValue, $assoc, $depth, $options);
    }

    /**
     * @param array $value
     * @param int|null $options
     * @param int|null $depth
     *
     * @return string|null
     */
    public function encodeJson(array $value, ?int $options = null, ?int $depth = null): ?string
    {
        return $this->utilEncodingService->encodeJson($value, $options, $depth);
    }
}
