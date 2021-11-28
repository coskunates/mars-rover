<?php

namespace App\System\Response;

/**
 * Class Error
 * @package App\System\Response
 */
class Error
{
    /**
     * @var int $code
     */
    public mixed $code;

    /**
     * @var string $message
     */
    public string $message;

    /**
     * @param mixed $code
     * @param string $message
     */
    public function __construct(mixed $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCode(): mixed
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}