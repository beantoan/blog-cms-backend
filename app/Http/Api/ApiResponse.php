<?php
namespace App\Http\Api;

class ApiResponse
{
    private $code;

    private $msg;

    private $data;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get array of data when the variable is not empty
     *
     * @return array
     */
    public function toArray()
    {
        $response = [];

        if (!empty($this->getCode())) {
            $response['code'] = $this->getCode();
        }

        if (!empty($this->getMsg())) {
            $response['msg'] = $this->getMsg();
        }

        if (!empty($this->getData())) {
            $response['data'] = $this->getData();
        }

        return $response;
    }
}