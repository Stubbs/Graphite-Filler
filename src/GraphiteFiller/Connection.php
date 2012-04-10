<?php
/**
 * Class to interface with a graphite server.
 *
 * @author Stuart Grimshaw <stuart@localphone.com>
 * @version $Id$
 * @copyright Stuart Grimshaw <stuart@localphone.com>, 08 April, 2012
 * @package GraphiteFiller
 */

Namespace GraphiteFiller;

require_once 'src/GraphiteFiller/SocketProxy.inc';

use GraphiteFiller\SocketProxy;

/**
 * Class to interface with a graphite server.
 *
 * @package GraphiteFiller
 * @author Stuart Grimshaw <stuart@localphone.com>
 */
class Connection
{
    protected $_host="localhost";
    protected $_port=2003;
    protected $_address="127.0.0.1";

    private $_socket;

    public function __construct($host=null, $port=null) {
        if($host != null) {
            $this->_host = $host;
        }

        if($port != null) {
            $this->_port = $port;
        }

        $this->_address = gethostbyname($this->_host);

        $this->_socket = new SocketProxy();
    }

    /**
     * Gets the value of socket
     *
     * @return resource
     */
    public function getSocket()
    {
        return $this->_socket;
    }

    /**
     * Sets the value of socket
     *
     * @param mixed $socket
     */
    public function setSocket($socket)
    {
        $this->_socket = $socket;
    }

    public function connect() {
        print "Connecting to " . $this->_address . "\n";

        $this->_socket->connect($this->_address, $this->_port);
    }

    public function send($metric, $value, $time) {
        $buf = "$metric $value $time\n\r";

        $this->_socket->write($buf);
    }

    /**
     * Gets the value of host
     *
     * @return String
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * Sets the value of host
     *
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->_host = $host;
    }

    /**
     * Gets the value of port
     *
     * @return String
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
     * Sets the value of port
     *
     * @param mixed $Port
     */
    public function setport($port)
    {
        $this->_port = $port;
    }
} // END class Graphite

?>
