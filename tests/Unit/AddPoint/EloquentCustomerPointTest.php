<?php
declare(strict_types=1);

namespace Tests\Unit\AddPoint;

use App\Eloquent\EloquentCustomer;
use App\Eloquent\EloquentCustomerPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentCustomerPointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function register()
    {
        // テストに必要なレコードを登録
        $customerId = 1;
        factory(EloquentCustomer::class)->create([
            'id' => $customerId,
        ]);
        factory(EloquentCustomerPoint::class)->create([
            'customer_id' => $customerId,
            'point'       => 100,
        ]);

        // テスト対象のメソッドを実行
        $eloquent = new EloquentCustomerPoint();
        $result = $eloquent->addPoint($customerId, 10);

        // テスト結果のアサーション
        $this->assertDatabaseHas('customer_points', [
            'customer_id' => $customerId,
            'point'       => 110,
        ]);
    }
}
