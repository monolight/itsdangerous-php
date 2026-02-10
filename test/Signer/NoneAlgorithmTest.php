<?php

use ItsDangerous\Signer\NoneAlgorithm;
use PHPUnit\Framework\TestCase;

class NoneAlgorithmTest extends TestCase
{

    public function testGetSignature_shouldReturnEmptySignature()
    {
        $algo = new NoneAlgorithm();

        $sig = $algo->get_signature('secret', 'hello');

        $this->assertEquals('', $sig);
    }

}
