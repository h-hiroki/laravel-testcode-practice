<?php
declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CalculatePointService;

class CalculatePointServiceTest extends TestCase
{
    public function dataProvider_for_calcPoint(): array
    {
        // Point キーを指定した方がどのケースでFailになったか分かり易い
        return [
            '購入金額が0なら0ポイント'     => [0, 0],
            '購入金額が999なら0ポイント'   => [0, 999],
            '購入金額が1000なら0ポイント'  => [10, 1000],
            '購入金額が9999なら0ポイント'  => [99, 9999],
            '購入金額が10000なら0ポイント' => [200, 10000],
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_for_calcPoint
     */
    public function calcPoint(int $expected, int $amount)
    {
        $result = CalculatePointService::calcPoint($amount);
        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @expectedException \App\Exceptions\PreConditionException
     * @expectedExceptionMessage 購入金額が負の数
     */
    public function calcPoint_購入金額が負の数なら例外をスロー()
    {
        CalculatePointService::calcPoint(-1);
    }


    // 以下はいくつかの例外をテストする場合の書き方。参考にしてね。

    /**
     * try/catchを使った例外テスト
     * @test
     */
    public function exception_try_catch()
    {
        try {
            throw new \InvalidArgumentException('message', 200);
            $this->fail(); // 例外がスローされていない場合はテストを失敗させる
        } catch (\Throwable $e){
            // 指定した例外クラスがスローされているか
            $this->assertInstanceOf(\InvalidArgumentException::class, $e);
            // スローされた例外のコードを検証
            $this->assertSame(200, $e->getCode());
            // スローされた例外のメッセージを検証
            $this->assertSame('message', $e->getMessage());
        }
    }

    /**
     * expectExceptionメソッドを使った例外テスト
     * @test
     */
    public function exception_expectException_method()
    {
        // 指定した例外クラスがスローされているか
        $this->expectException(\InvalidArgumentException::class);
        // スローされた例外のコードを検証
        $this->expectExceptionCode(200);
        // スローされた例外のメッセージを検証
        $this->expectExceptionMessage('message');

        throw new \InvalidArgumentException('message', 200);
    }

    /**
     * expectedExceptionアノテーションを使った例外テスト
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 200
     * @expectedExceptionMessage message
     */
    public function exception_expectedException_annotation()
    {
        throw new \InvalidArgumentException('message', 200);
    }
}
