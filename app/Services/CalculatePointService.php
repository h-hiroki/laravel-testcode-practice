<?php
declare(strict_types=1); // php7から入った厳格な型チェックモードを有効にする

namespace App\Services;

use App\Exceptions\PreConditionException;

final class CalculatePointService
{

    /**
     * ポイント計算を行う。
     * 1000〜9999円の場合は100円につき1ポイント
     * 10000円以上の場合は100円につき2ポイント
     *
     * @param int $amount
     * @return int
     * @throws PreConditionException
     */
    public function calcPoint(int $amount): int
    {
        if ($amount < 0) {
            throw new PreConditionException('購入金額が負の数');
        }

        if ($amount < 1000) {
            return 0;
        }

        if ($amount < 10000) {
            $basePoint = 1;
        } else {
            $basePoint = 2;
        }

        return intval($amount / 100) * $basePoint;
    }
}