<?php

require_once 'src/GraphiteFiller/Connection.php';

use GraphiteFiller\Connection;

class GraphiteTest extends PHPUnit_Framework_TestCase
{
    private $mockSocket;

    public function __construct() {
        $this->mockSocket = $this->getMockBuilder('SocketProxy')
            ->setMethods(array('connect', 'write'))
            ->DisableOriginalConstructor()
            ->getMock();
    }

    public function testConnectionObject()
    {
        $connection = new Connection("127.0.0.1", 2004);
        $connection->setSocket($this->mockSocket);

        $this->assertEquals("127.0.0.1", $connection->getHost());
        $this->assertEquals("2004", $connection->getPort());
    }

    public function testConnection()
    {
        $conn = new Connection("127.0.0.1", 2003);

        $this->mockSocket->expects($this->once())
            ->method('connect')
            ->with("127.0.0.1", 2003);

        $this->expectOutputString("Connecting to 127.0.0.1\n");

        $conn->setSocket($this->mockSocket);

        $conn->connect();

    }

    public function testSend()
    {
        $conn = new Connection("127.0.0.1", 2003);

        $this->mockSocket->expects($this->once())
            ->method('connect')
            ->with("127.0.0.1", 2003);

        $this->mockSocket->expects($this->once())
            ->method('write')
            ->with("test.stat 1 1345\n\r");

        $this->expectOutputString("Connecting to 127.0.0.1\n");

        $conn->setSocket($this->mockSocket);

        $conn->connect();

        $conn->send("test.stat", "1", 1345);
    }
}
?>
