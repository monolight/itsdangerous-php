<?php

use ItsDangerous\BadData\BadSignature;
use ItsDangerous\Signer\Signer;
use PHPUnit\Framework\TestCase;

class SignerTest extends TestCase
{

    public function testSigner_signAndUnsign_shouldBeCongruent()
    {
        $s = new Signer("secret");
        $foo = $s->sign("hello");
        $this->assertEquals('hello.7KTthSs1fJgtbigPvFpQH1bpoGA', $foo);

        $bar = $s->unsign($foo);
        $this->assertEquals('hello', $bar);
    }

    public function testSigner_unsignTamperedData_shouldChoke()
    {
        $this->expectException(BadSignature::class);

        $s = new Signer("secret");
        $bar = $s->unsign('hallo.7KTthSs1fJgtbigPvFpQH1bpoGA');
    }

    public function testSigner_unsignMalformedData_shouldChoke()
    {
        $this->expectException(BadSignature::class);

        $s = new Signer("secret");
        $bar = $s->unsign('hallo7KTthSs1fJgtbigPvFpQH1bpoGA');
    }

    public function testSigner_deriveKeyByConcat_shouldWork()
    {
        $s = new Signer("secret", 'salty', '.', 'concat');
        $foo = $s->sign("hello");
        $this->assertEquals('hello.xsKaFG-7aZBLFXwEoyVfhXy0Btk', $foo);

        $bar = $s->unsign($foo);
        $this->assertEquals('hello', $bar);
    }

    public function testSigner_deriveKeyByHMAC_shouldWork()
    {
        $s = new Signer("secret", 'salty', '.', 'hmac');
        $foo = $s->sign("hello");
        $this->assertEquals('hello.lcna0Kctpa6ne47lHrYKfTEsdew', $foo);

        $bar = $s->unsign($foo);
        $this->assertEquals('hello', $bar);
    }

    public function testSigner_deriveKeyByGarbage_shouldChoke()
    {
        $this->expectException(\Exception::class);
        $s = new Signer("secret", 'salty', '.', 'garbage');
        $foo = $s->sign("hello");
    }

    public function testSigner_validateClean_shouldBeTrue()
    {
        $foo = 'hello.7KTthSs1fJgtbigPvFpQH1bpoGA';

        $s = new Signer("secret");
        $bar = $s->validate($foo);

        $this->assertTrue($bar);
    }

    public function testSigner_validateTampered_shouldBeFalse()
    {
        $foo = 'hillo.7KTthSs1fJgtbigPvFpQH1bpoGA';

        $s = new Signer("secret");
        $bar = $s->validate($foo);

        $this->assertFalse($bar);
    }


}
