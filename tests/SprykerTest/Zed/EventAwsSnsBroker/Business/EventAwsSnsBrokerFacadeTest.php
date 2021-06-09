<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\EventAwsSnsBroker\Business;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventCollectionTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\EventTransfer;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerDependencyProvider;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group EventAwsSnsBroker
 * @group Business
 * @group Facade
 * @group EventAwsSnsBrokerFacadeTest
 * Add your own group annotations below this line
 *
 * @property \SprykerTest\Zed\EventAwsSnsBroker\EventAwsSnsBrokerBusinessTester $tester
 */
class EventAwsSnsBrokerFacadeTest extends Unit
{
    protected const TEST_EVENT_BUS_NAME_ONE = 'testNameOne';
    protected const TEST_EVENT_BUS_NAME_TWO = 'testNameTwo';

    /**
     * @return void
     */
    public function testIsEventNotificationCorrectShouldBeTrue(): void
    {
        // Act
        $result = $this->getFacade()->isEventNotificationCorrect([], [], '');

        // Assert
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testCreateTopicsShouldBeSuccess(): void
    {
        // Arrange
        $eventAwsSnsClientMock = $this->getMockBuilder(EventAwsSnsBrokerClientInterface::class)
            ->getMock();
        $eventAwsSnsClientMock->expects($this->once())
            ->method('createTopic')
            ->with(static::TEST_EVENT_BUS_NAME_ONE);

        $this->tester->setDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER, $eventAwsSnsClientMock);

        // Act
        $this->getFacade()->createTopics([static::TEST_EVENT_BUS_NAME_ONE]);
    }

    /**
     * @return void
     */
    public function testCreateTopicsShouldClientBeCalledTwice(): void
    {
        // Arrange
        $eventAwsSnsClientMock = $this->getMockBuilder(EventAwsSnsBrokerClientInterface::class)
            ->getMock();
        $eventAwsSnsClientMock->expects($this->exactly(2))
            ->method('createTopic');

        $this->tester->setDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER, $eventAwsSnsClientMock);

        // Act
        $this->getFacade()->createTopics([static::TEST_EVENT_BUS_NAME_ONE, static::TEST_EVENT_BUS_NAME_TWO]);
    }

    /**
     * @return void
     */
    public function testCreateSubscribersShouldBeSuccess(): void
    {
        // Arrange
        $topicArn = $this->getTopicArn(static::TEST_EVENT_BUS_NAME_ONE);
        $eventAwsSnsClientMock = $this->getMockBuilder(EventAwsSnsBrokerClientInterface::class)
            ->getMock();
        $eventAwsSnsClientMock->expects($this->once())
            ->method('createSubscriber')
            ->with($topicArn);

        $this->tester->setDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER, $eventAwsSnsClientMock);

        // Act
        $this->getFacade()->createSubscribers([static::TEST_EVENT_BUS_NAME_ONE => $topicArn]);
    }

    /**
     * @return void
     */
    public function testCreateSubscribersShouldClientBeCalledTwice(): void
    {
        // Arrange
        $map = [
            static::TEST_EVENT_BUS_NAME_ONE => $this->getTopicArn(static::TEST_EVENT_BUS_NAME_ONE),
            static::TEST_EVENT_BUS_NAME_TWO => $this->getTopicArn(static::TEST_EVENT_BUS_NAME_TWO),
        ];
        $eventAwsSnsClientMock = $this->getMockBuilder(EventAwsSnsBrokerClientInterface::class)
            ->getMock();
        $eventAwsSnsClientMock->expects($this->exactly(2))
            ->method('createSubscriber');

        $this->tester->setDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER, $eventAwsSnsClientMock);

        // Act
        $this->getFacade()->createSubscribers($map);
    }

    /**
     * @return void
     */
    public function testPublishEventsShouldBeSuccess(): void
    {
        // Arrange
        $eventTransfers = new ArrayObject();
        $eventTransfer = new EventTransfer();
        $eventTransfers->append($eventTransfer);
        $eventTransfer = new EventTransfer();
        $eventTransfers->append($eventTransfer);
        $eventTransfer = new EventTransfer();
        $eventTransfers->append($eventTransfer);

        $eventCollectionTransfer = new EventCollectionTransfer();
        $eventCollectionTransfer->setEvents($eventTransfers);
        $eventCollectionTransfer->setEventBusName(static::TEST_EVENT_BUS_NAME_ONE);

        $topicArn = $this->getTopicArn(static::TEST_EVENT_BUS_NAME_ONE);
        $this->tester->mockConfigMethod(
            'getAwsSnsTopicArnMappedWithEventBusNames',
            [static::TEST_EVENT_BUS_NAME_ONE => $topicArn]
        );

        $eventAwsSnsClientMock = $this->getMockBuilder(EventAwsSnsBrokerClientInterface::class)
            ->getMock();
        $eventAwsSnsClientMock->expects($this->exactly(3))
            ->method('publishEvent')
            ->with($topicArn);

        $this->tester->setDependency(EventAwsSnsBrokerDependencyProvider::CLIENT_EVENT_AWS_SNS_BROKER, $eventAwsSnsClientMock);

        // Act
        $this->getFacade()->publishEvents($eventCollectionTransfer);
    }

    /**
     * @return void
     */
    public function testHandleEventShouldBeSuccess(): void
    {
        // Arrange
        $nameEventEntity = 'Test event entity name';
        $eventEntityTransfer = new EventEntityTransfer();
        $eventEntityTransfer->setName($nameEventEntity);

        $eventName = 'Test.event.name';
        $eventTransfer = new EventTransfer();
        $eventTransfer->setEventName($eventName);
        $eventTransfer->setMessage($eventEntityTransfer);
        $eventTransfer->setMessageType(EventEntityTransfer::class);

        $eventAwsSnsBrokerToEventFacadeBridgeMock = $this->getMockBuilder(EventAwsSnsBrokerToEventFacadeInterface::class)
            ->getMock();
        $eventAwsSnsBrokerToEventFacadeBridgeMock->expects($this->once())
            ->method('dispatchEvents')
            ->willReturnCallback(function (EventCollectionTransfer $eventCollectionTransfer) use ($eventName, $nameEventEntity): void {
                $this->assertEquals(static::TEST_EVENT_BUS_NAME_ONE, $eventCollectionTransfer->getEventBusName());
                $eventTransfer = $eventCollectionTransfer->getEvents()[0];
                $this->assertEquals($eventName, $eventTransfer->getEventName());
                $this->assertInstanceOf(EventEntityTransfer::class, $eventTransfer->getMessage());
                $this->assertEquals($nameEventEntity, $eventTransfer->getMessage()->getName());
            });

        $this->tester->setDependency(EventAwsSnsBrokerDependencyProvider::FACADE_EVENT, $eventAwsSnsBrokerToEventFacadeBridgeMock);

        $encodedMessage = json_encode($eventTransfer->toArray());

        // Act
        $this->getFacade()->handleEvent($encodedMessage, static::TEST_EVENT_BUS_NAME_ONE);
    }

    /**
     * @return \Spryker\Zed\EventAwsSnsBroker\Business\EventAwsSnsBrokerFacadeInterface|\Spryker\Zed\Kernel\Business\AbstractFacade
     */
    protected function getFacade(): EventAwsSnsBrokerFacadeInterface
    {
        return $this->tester->getFacade();
    }

    /**
     * @param string $eventBusName
     *
     * @return string
     */
    protected function getTopicArn(string $eventBusName): string
    {
        return 'arn:aws:sns:000000000000:eu-central-1:' . $eventBusName;
    }
}
