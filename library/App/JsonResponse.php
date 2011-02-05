<?php
namespace App;

/**
 * Handles a JSON response, encoding it and sorting the proper parts
 *
 * @category FBTUM
 * @package App
 */
class JsonResponse
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $data;

    /**
     * Builds a JSON Response
     *
     * @param int $code
     * @param string $message
     * @param array $data
     */
    public function __construct($code = null, $message = null, $data = null)
    {
        $this->setCode($code);
        $this->setMessage($message);
        $this->setData($data);
    }

    /**
     * Formats output array and encodes it
     *
     * @return string
     */
    private function buildOutput()
    {

        $output = array();
        $output['code'] = $this->getCode();
        $output['message'] = $this->getMessage();
        $output['data'] = $this->getData();

        return \json_encode($output);
    }

    /**
     * Echos output
     */
    public function sendOutput()
    {
        echo $this->buildOutput();
    }

    /**
     * Retrieves output string
     * @return string
     */
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
