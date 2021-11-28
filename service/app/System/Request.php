<?php

namespace App\System;

use App\Exceptions\NotFoundException;

/**
 * Class Request
 * @package App\System
 */
class Request
{
    /**
     * Request Method
     *
     * @var string $method
     */
    protected string $method = '';

    /**
     * Request Uri
     *
     * @var string $uri
     */
    protected string $uri = '';

    /**
     * @var string $contentType
     */
    protected string $contentType = '';

    /**
     * All request parameters
     *
     * @var array $params
     */
    protected array $params = [];

    /**
     * Request Constructor
     */
    public function __construct()
    {
        $this->setMethod($_SERVER['REQUEST_METHOD']);
        $this->setUri($_SERVER['REQUEST_URI']);
        $this->setContentType(!empty($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '');
        $this->setParams();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = strtolower($method);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $explodedUri = explode('?', $uri);

        $this->uri = strtolower($explodedUri[0]);
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = strtolower($contentType);
    }

    /**
     * Sets request parameters
     */
    protected function setParams()
    {
        $this->_setPostParameters();
        $this->_setGetParameters();
        $this->_setInputs();
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getParam(string $key): mixed
    {
        return $this->params[$key];
    }

    /**
     * Sets post parameters to params if request method is post
     */
    private function _setPostParameters(): void
    {
        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $this->params[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    /**
     * Sets post parameters to params if request method is get
     */
    private function _setGetParameters()
    {
        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $this->params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    /**
     * If  content type header is equal to application/json then read inputs and set parameters
     */
    private function _setInputs(): void
    {
        if ($this->getContentType() === 'application/json') {
            $body = trim(file_get_contents("php://input"));
            $this->params = json_decode($body, true);
        }
    }

    /**
     * Start handle request
     */
    public function start(): void
    {
        $route = Router::get($this->getMethod(), $this->getUri());
        if (!empty($route['class']) && !empty($route['method'])) {
            $args = [];
            if (!empty($route['args'])) {
                $args = $route['args'];
            }

            call_user_func_array(
                [(new $route['class']), $route['method']],
                $args
            );
        } else {
            throw new NotFoundException('Requested route is not found.');
        }
    }
}