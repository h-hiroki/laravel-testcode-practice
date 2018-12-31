<?php
declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Eloquent\EloquentCustomer;
use App\Eloquent\EloquentCustomerPoint;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddPointTest extends TestCase
{
    use RefreshDatabase;

    const CUSTOMER_ID = 1;

    protected function setUp()
    {
        parent::setUp();

        Carbon::setTestNow();

        // テストに必要なレコードを登録
        factory(EloquentCustomer::class)->create([
            'id' => self::CUSTOMER_ID,
        ]);
        factory(EloquentCustomerPoint::class)->create([
            'customer_id' => self::CUSTOMER_ID,
            'point'       => 100,
        ]);
    }

    /**
     * @test
     */
    public function put_add_point()
    {
        // API実行
        $response = $this->putJson('/api/customers/add_point', [
            'customer_id' => self::CUSTOMER_ID,
            'add_point'       => 10,
        ]);

        // HTTPレスポンスアサーション
        $response->assertStatus(200);
        $expected = ['customer_point' => 110];
        $response->assertExactJson($expected);

        // データベースアサーション
        $this->assertDatabaseHas('customer_points', [
            'customer_id' => self::CUSTOMER_ID,
            'point'       => 110,
        ]);
        $this->assertDatabaseHas('customer_point_events', [
            'customer_id' => self::CUSTOMER_ID,
            'event'       => 'ADD_POINT',
            'point'       => 10,
            'created_at'  => Carbon::now(),
        ]);
    }

    /**
     * @test
     */
    public function put_add_point_バリデーションエラー()
    {
        // API実行
        $response = $this->putJson('/api/customers/add_point', []);

        // HTTPレスポンスアサーション
        $response->assertStatus(422);
        $expected = [
            'message' => 'The given data was invalid.',
            'errors'  => [
                'customer_id' => [
                    'The customer id field is required.',
                ],
                'add_point' => [
                    'The add point field is required.',
                ],
            ],
        ];
        $response->assertExactJson($expected);
    }
}