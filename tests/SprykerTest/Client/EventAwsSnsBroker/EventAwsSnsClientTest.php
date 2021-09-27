<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\EventAwsSnsBroker;

use Aws\Sns\SnsClient;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\EventAwsSnsBroker\ApiClient\AwsSnsApiClient;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerFactory;
use Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group EventAwsSnsBroker
 * @group EventAwsSnsClientTest
 * Add your own group annotations below this line
 *
 * @property \SprykerTest\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientTester $tester
 */
class EventAwsSnsClientTest extends Unit
{
    /**
     * @var string
     */
    protected const TEST_EVENT_BUS_NAME_ONE = 'testNameOne';

    /**
     * @var string
     */
    protected const TEST_SUBSCRIPTION_TOKEN = 'tokenP3843j2423klj423094u234kjol42j34ok';

    /**
     * @return void
     */
    public function testCreateTopicsShouldBeSuccess(): void
    {
        // Arrange
        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['createTopic'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('createTopic')
            ->willReturnCallback(function (array $requestBody): array {
                return ['TopicArn' => 'topicArn:' . $requestBody['Name']];
            });

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);

        // Act
        $topicArn = $eventAwsSnsClient->createTopic(static::TEST_EVENT_BUS_NAME_ONE);

        // Assert
        $this->assertEquals('topicArn:' . static::TEST_EVENT_BUS_NAME_ONE, $topicArn);
    }

    /**
     * @return void
     */
    public function testCreateTopicsShouldBeFailedResponse(): void
    {
        // Arrange
        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['createTopic'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('createTopic')
            ->willReturnCallback(function (): array {
                return [];
            });

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);
        $this->expectException(AwsSnsClientResponseException::class);

        // Act
        $eventAwsSnsClient->createTopic(static::TEST_EVENT_BUS_NAME_ONE);
    }

    /**
     * @return void
     */
    public function testCreateSubscriberShouldBeSuccess(): void
    {
        // Arrange
        $topicArn = 'topicArn:' . static::TEST_EVENT_BUS_NAME_ONE;

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['subscribe'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('subscribe')
            ->willReturnCallback(function (array $requestBody): array {
                return ['SubscriptionArn' => $requestBody['TopicArn'] . ':test'];
            });

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);

        // Act
        $subscriberArn = $eventAwsSnsClient->createSubscriber($topicArn, 'http://test.local', 'http');

        // Assert
        $this->assertEquals($topicArn . ':test', $subscriberArn);
    }

    /**
     * @return void
     */
    public function testCreateSubscriberShouldBeFailedResponse(): void
    {
        // Arrange
        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['subscribe'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('subscribe')
            ->willReturnCallback(function (): array {
                return [];
            });

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);
        $this->expectException(AwsSnsClientResponseException::class);

        // Act
        $eventAwsSnsClient->createSubscriber('', '', '');
    }

    /**
     * @return void
     */
    public function testConfirmSubscriptionShouldBeSuccess(): void
    {
        // Arrange
        $topicArn = 'topicArn:' . static::TEST_EVENT_BUS_NAME_ONE;

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['confirmSubscription'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('confirmSubscription')
            ->willReturn(['SubscriptionArn' => $topicArn]);

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);

        // Act
        $subscriberArn = $eventAwsSnsClient->confirmSubscription($topicArn, static::TEST_SUBSCRIPTION_TOKEN);

        // Assert
        $this->assertEquals($topicArn, $subscriberArn);
    }

    /**
     * @return void
     */
    public function testConfirmSubscriptionShouldBeFailedResponse(): void
    {
        // Arrange
        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['confirmSubscription'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('confirmSubscription')
            ->willReturn([]);

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);
        $this->expectException(AwsSnsClientResponseException::class);

        // Act
        $eventAwsSnsClient->confirmSubscription('', '');
    }

    /**
     * @return void
     */
    public function testPublishEventShouldBeSuccess(): void
    {
        // Arrange
        $message = uniqid();

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['publish'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('publish')
            ->willReturnCallback(function (array $requestBody): array {
                return ['MessageId' => 'test:' . $requestBody['Message']];
            });

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);

        // Act
        $idMessage = $eventAwsSnsClient->publishEvent('topicArn', $message);

        // Assert
        $this->assertEquals('test:' . $message, $idMessage);
    }

    /**
     * @return void
     */
    public function testPublishEventShouldBeFailedResponse(): void
    {
        // Arrange
        /** @var \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock */
        $snsClientMock = $this->getMockBuilder(SnsClient::class)
            ->disableOriginalConstructor()
            ->addMethods(['publish'])
            ->getMock();
        $snsClientMock->expects($this->once())
            ->method('publish')
            ->willReturnCallback(function (): array {
                return [];
            });

        $eventAwsSnsClient = $this->getEventAwsSnsBrokerClient($snsClientMock);
        $this->expectException(AwsSnsClientResponseException::class);

        // Act
        $eventAwsSnsClient->publishEvent('', '');
    }

    /**
     * @param \PHPUnit\Framework\MockObject\MockObject|\Aws\Sns\SnsClient $snsClientMock
     *
     * @return \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected function getEventAwsSnsBrokerClient(MockObject $snsClientMock): EventAwsSnsBrokerClientInterface
    {
        /** @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface|\Spryker\Client\Kernel\AbstractClient $eventAwsSnsClient */
        $eventAwsSnsClient = $this->tester->getLocator()->eventAwsSnsBroker()->client();

        $awsSnsApiClient = new AwsSnsApiClient($snsClientMock);

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerFactory $eventAwsSnsBrokerFactoryMock */
        $eventAwsSnsBrokerFactoryMock = $this->getMockBuilder(EventAwsSnsBrokerFactory::class)
            ->getMock();
        $eventAwsSnsBrokerFactoryMock->method('createApiClient')
            ->willReturn($awsSnsApiClient);
        $eventAwsSnsClient->setFactory($eventAwsSnsBrokerFactoryMock);

        return $eventAwsSnsClient;
    }
}
