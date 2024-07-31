<?php

namespace Tests\Unit;

use phpseclib\Crypt\RSA;
use Tests\TestCase;

class CryptoTest extends TestCase
{
    /**
     * A basic test to check if PHPSecLib is installed.
     */
    public function testLibraryInstalled(): void
    {
        $this->assertTrue(class_exists('\phpseclib\Crypt\RSA'));
    }

    public function testRSASigning(): void
    {
        $rsa = new RSA();
        extract($rsa->createKey());
        $rsa->loadKey($privatekey);
        $plaintext = 'pixelfed rsa test';
        $signature = $rsa->sign($plaintext);
        $rsa->loadKey($publickey);
        $this->assertTrue($rsa->verify($plaintext, $signature));
    }
}
