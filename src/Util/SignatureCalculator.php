<?php

namespace Omnipay\Paynow\Util;

class SignatureCalculator
{
    /** @var string */
    protected $hash;

    /**
     * @param string $signatureKey
     * @param string $data
     */
    public function __construct($signatureKey, $data)
    {
        $this->hash = base64_encode(hash_hmac('sha256', $data, $signatureKey, true));
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
