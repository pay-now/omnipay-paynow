<?php

namespace Omnipay\Paynow\Util;

use Omnipay\Tests\TestCase;

class SignatureCalculatorTest extends TestCase
{
    public function testNotValidSuccessfully()
    {
        //given
        $signatureCalculator = new SignatureCalculator('InvalidSecretKey', json_encode(['key' => 'value']));

        //when
        $siganture = $signatureCalculator->getHash();

        //then
        $this->assertNotEquals('hash', $siganture);
    }

    public function testShouldValidSuccessfully()
    {
        //given
        $signatureCalculator = new SignatureCalculator(
            'a621a1fb-b4d8-48ba-a6a3-2a28ed61f605',
            json_encode([
                'key1' => 'value1',
                'key2' => 'value2',
            ])
        );

        //when
        $siganture = $signatureCalculator->getHash();

        //then
        $this->assertEquals('rFAkhfbUFRn4bTR82qb742Mwy34g/CSi8frEHciZhCU=', $siganture);
    }
}