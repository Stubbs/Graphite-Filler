<?php
/**
 * proxy class for PHP's socket_* functions, used mainly when the code
 * you're writing is going to be unit tested.
 *
 * @author Stuart Grimshaw <stuart@localphone.com>
 * @version $Id$
 * @copyright Stuart Grimshaw <stuart@localphone.com>, 10 April, 2012
 * @package GraphiteFiller
 */

Namespace GraphiteFiller;

require_once 'src/GraphiteFiller/SocketException.inc';

use GraphiteFiller\SocketException;

/**
 * Proxy class for the non-oo socket_* methods, allows easy unit testing of socket
 * based classes.
 *
 * @package GraphiteFiller
 * @author Stuart Grimshaw <stuart@localphone.com>
 */
class SocketProxy
{
    /**
     * Holds the socket that the rest of the methods are connecting to.
     *
     * @see __construct()
     * @var resource
     */
    private $_socket = null;

    /**
     * Constructor creates a new socket fr the rest of the methods on the class to use.
     *
     * Creates, but does now automatically connect.
     *
     * @see http://www.php.net/manual/en/function.socket-create.php
     * @param int $domain Defaults to AF_INET (ipv4)
     * @param int $type Defaults to a stream socket
     * @param int $protocol Defaults to TCP.
     * @return void
     * @throws SocketException
     * @author Stuart Grimshaw <stuart@localphone.com>
     */
    public function __construct($domain=AF_INET, $type=SOCK_STREAM, $protocol=SOL_TCP)
    {
        $this->_socket = socket_create($domain, $type, $protocol);

        if($this->_socket === false) {
            throw new SocketException(socket_strerror(socket_last_error()), socket_last_error());
        }
    }

    /**
     * Disconnect & null the connection.
     *
     * @return void
     * @author Stuart Grimshaw <stuart@localphone.com>
     */
    public function __destroy()
    {
        socket_close($this->socket);
    }

    /**
     * Connects the socket to the specified address & port.
     *
     * Essentially just wraps the socket_connect method.
     *
     * @param string $address The IP address of the server to connect to.
     * @param int $port The number of the port to connect to. There is no default.
     * @return void
     * @throws SocketException
     * @author Stuart Grimshaw <stuart@localphone.com>
     */
    public function connect($address, $port)
    {
        if (!socket_connect($this->_socket, $address, $port)) {
            throw new SocketException("socket_connect failed with error: " . socket_strerror(socket_last_error()), socket_last_error());
        }
    }

    /**
     * Writes the given message to the socket.
     *
     * @return void
     * @param string $message The message to write to the port.
     * @author Stuart Grimshaw <stuart@localphone.com>
     */
    function write($message)
    {
        if(!socket_write($this->_socket, $message)) {
            throw new SocketException("socket_write failed with error: " . socket_strerror(socket_last_error()), socket_last_error());
        }
    }
} // END class

?>
