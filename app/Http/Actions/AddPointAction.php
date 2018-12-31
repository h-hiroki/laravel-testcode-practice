<?php
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Requests\AddPointRequest;
use App\UseCases\AddPointUseCase;
use Illminate\Http\JsonResponse;
use Illminate\Support\Carbon;

class AddPointAction
{
    /** @var AddPointUseCase */
    private $useCase;

    /**
     * @param AddPointUseCase $useCase
     */
    public function __construct(AddPointUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param AddPointRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function __invoke(AddPointRequest $request): JsonResponse
    {
        // JSONからパラメタ取得
        $customerId = filter_var($request->json('customer_id'), FILTER_VALIDATE_INT);
        $addPoint = filter_var($request->json('add_point', FILTER_VALIDATE_INT));

        // ポイント加算ユースケース実行
        $customerPoint = $this->useCase->run(
            $customerId,
            $addPoint,
            'ADD_POINT',
            Carbon::now()
        );

        // レスポンス生成
        return response()->json(['customer_point' => $customerPoint]);
    }

}