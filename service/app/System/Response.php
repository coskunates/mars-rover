<?php

namespace App\System;

use App\System\Response\Error;

/**
 * Class Response
 * @package App\System
 */
class Response
{
    /**
     * @var ?Error $error
     */
    protected ?Error $error = null;

    /**
     * @var int $statusCode
     */
    protected int $statusCode = 200;

    /**
     * @var array $data
     */
    protected array $data = [];

    /**
     * @return Error|null
     */
    public function getError(): ?Error
    {
        return $this->error;
    }

    /**
     * @param string $message
     * @param mixed|int $code
     * @return $this
     */
    public function setError(string $message, mixed $code = 0): Response
    {
        $this->error = new Error($code, $message);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): Response
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): Response
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Generates api response
     *
     * @return void
     */
    public function generateResponse(): void
    {
        $result['error'] = false;
        if ($this->getError()) {
            $result['error'] = true;
            $result['message'] = $this->getError()->getMessage();
            $result['code'] = $this->getError()->getCode();
        } else {
            $result['data'] = $this->getData();
        }

        http_response_code($this->getStatusCode());
        header('Content-Type: application/json');

        die(json_encode($result));
    }
}