<?php

namespace Omnipay\Paynow\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Abstract Paynow Response.
 */
abstract class AbstractPaynowResponse extends AbstractResponse
{
    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed            $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->data = json_decode($data);
    }

    /**
     * Get a specific key value
     *
     * @param  string $key key to retrieve
     * @return mixed|null Value of the key or NULL
     */
    public function get($key)
    {
        return isset($this->data->$key) ? $this->data->$key : null;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function getCode()
    {
        if ($this->get('errorCode') && !$this->isSuccessful()) {
            return $this->data['errorCode'];
        }

        return null;
    }

    public function getMessage()
    {
        $errors = $this->get('errors');
        $messages = null;

        if ($errors && !$this->isSuccessful()) {
            foreach ($errors as $error) {
                $messages .= $error->message;
            }
        }

        return $messages;
    }
}
