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
}
