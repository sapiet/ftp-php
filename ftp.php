<?php

namespace FTP;

use Exception;

class FTP
{
    /**
     * Host
     * @var string
     */
    private $host;

    /**
     * FTP connection
     * @var [type]
     */
    private $connection;

    /**
     * FTP class constructor
     * 
     * @param string $host FTP server host
     * @param int    $port FTP server port
     * @param int    $timeout FTP connection timeout
     */
    public function __construct($host = null, $port = 21, $timeout = 90)
    {
        if ($host) {
            $this->connect($host, $port, $timeout);
        }
    }

    /**
     * Connect to FTP server
     * 
     * @param string $host FTP server host
     * @param int    $port FTP server port
     * @param int    $timeout FTP connection timeout
     * 
     * @return boolean      Connection OK
     * @throws \Exception   If connection fails
     */
    public function connect($host, $port = 21, $timeout = 90)
    {
        $this->host = $host;
        $this->connection = ftp_connect($this->host);

        if (!$this->connection) {
            throw new Exception('Unable to connect to server '.$this->host.':'.$port);
        }

        return true;
    }

    /**
     * FTP connection login
     * 
     * @param string $login    FTP server login
     * @param string $password FTP server password
     * 
     * @return boolean    FTP login OK
     * @throws \Exception If login fails
     */
    public function login($login, $password)
    {
        if (!ftp_login($this->connection, $login, $password)) {
            throw new Exception('Unable to connect to FTP '.$this->host.' with user '.$login);
        }

        return true;
    }

    /**
     * Save a file to FTP server
     * 
     * @param  [type] $originalDestination [description]
     * @param  [type] $destination         [description]
     * 
     * @return boolean                      [description]
     */
    public function save($originalDestination, $destination)
    {
        if (!file_exists($originalDestination)) {
            throw new Exception('File '.$originalFile.' does not exist');
        }

        if (!ftp_put($this->connection, $destination, $originalDestination, FTP_BINARY)) {
            throw new Exception('Cannot upload '.$originalDestination.' to '.$this->host.':'.$destination);
        }

        return true;
    }

    /**
     * Close FTP connection
     * 
     * @return boolean    If FTP connection is closed
     * @throws \Exception If no FTP connection to close
     */
    public function close()
    {
        if (!$this->connection) {
            throw new Exception('No connection to close');
        }

        return ftp_close($this->connection);
    }
}
