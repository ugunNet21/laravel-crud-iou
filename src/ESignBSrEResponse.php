<?php


namespace DiskominfotikBandaAceh\ESignBSrE;


class ESignBSreResponse
{
    private $status;
    private $errors;
    private $data;
    private $response;
    private const STATUS_OK = 200;

    public function __construct($response)
    {
        $this->response = $response;

        $this->setStatus();
        $this->setErrors();
        $this->setData();
    }

    private function setStatus(): void
    {
        $this->status = $this->response->status();
    }


    public function getStatus(): int
    {
        return $this->status;
    }


    public function setErrors(): void
    {
        if ($this->status != self::STATUS_OK){
            $this->errors = json_decode($this->response->body())->error;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }


    public function setData(): void
    {
        if ($this->status == self::STATUS_OK){
            $this->data = $this->response->body();
        }
    }


    public function getData()
    {
        return $this->data;
    }
}
