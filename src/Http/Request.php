<?php

namespace oNeDaL\ReactRestify\Http;

use React\Http\Request as ReactHttpRequest;
use Evenement\EventEmitter;

class Request extends EventEmitter
{
    public $httpRequest;
    private $data = [];
    private $rowBodyData = [];

    public function __construct(ReactHttpRequest $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    /**
     * Set the data array
     * @param array $data array of data
     */
    public function setData($data)
    {
        $this->data = array_merge($data, $this->data);
    }

    /**
     * Get the data array
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function setRowBodyData(array $data)
    {
        $this->rowBodyData = array_merge($data, $this->rowBodyData);
    }

    public function getRowBodyData()
    {
        return $this->rowBodyData;
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : (isset($this->rowBodyData[$name]) ? $this->rowBodyData[$name] : false);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
}
