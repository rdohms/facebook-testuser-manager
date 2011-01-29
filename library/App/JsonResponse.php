<?php
namespace App;

class JsonResponse
{

    protected $code;

    protected $message;

    protected $data;

    public function __construct($code = null, $message = null, $data = null)
    {
        $this->setCode($code);
        $this->setMessage($message);
        $this->setData($data);
    }

    private function buildOutput()
    {

        $output = array();
        $output['code'] = $this->getCode();
        $output['message'] = $this->getMessage();
        $output['data'] = $this->getData();

        return \json_encode($output);
    }

    public function sendOutput()
    {
        echo $this->buildOutput();
    }

    public function getOutput()
    {
        return $this->buildOutput();
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }



}

?>
