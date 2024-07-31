<?php

namespace Tests\Unit;

use App\Util\Lexer\Bearcap;
use PHPUnit\Framework\TestCase;

class BearcapTest extends TestCase
{
    /** @test */
    public function validTest(): void
    {
        $str = 'bear:?t=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2&u=https://pixelfed.test/stories/admin/337892163734081536';
        $expected = [
            'token' => 'LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2',
            'url' => 'https://pixelfed.test/stories/admin/337892163734081536',
        ];
        $actual = Bearcap::decode($str);
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function invalidTokenParameterName(): void
    {
        $str = 'bear:?token=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2&u=https://pixelfed.test/stories/admin/337892163734081536';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }

    /** @test */
    public function invalidUrlParameterName(): void
    {
        $str = 'bear:?t=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2&url=https://pixelfed.test/stories/admin/337892163734081536';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }

    /** @test */
    public function invalidScheme(): void
    {
        $str = 'bearcap:?t=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2&url=https://pixelfed.test/stories/admin/337892163734081536';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }

    /** @test */
    public function missingToken(): void
    {
        $str = 'bear:?u=https://pixelfed.test/stories/admin/337892163734081536';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }

    /** @test */
    public function missingUrl(): void
    {
        $str = 'bear:?t=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }

    /** @test */
    public function invalidHttpUrl(): void
    {
        $str = 'bear:?t=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2&u=http://pixelfed.test/stories/admin/337892163734081536';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }

    /** @test */
    public function invalidUrlSchema(): void
    {
        $str = 'bear:?t=LpVypnEUdHhwwgXE9tTqEwrtPvmLjqYaPexqyXnVo1flSfJy5AYMCdRPiFRmqld2&u=phar://pixelfed.test/stories/admin/337892163734081536';
        $actual = Bearcap::decode($str);
        $this->assertFalse($actual);
    }
}
