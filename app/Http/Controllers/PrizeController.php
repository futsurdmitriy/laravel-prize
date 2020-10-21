<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersPrize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\PrizeItem;
use App\Models\Money;
use App\Models\Point;
use App\Utility\RandomUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrizeController extends Controller
{
    /**
     * Gets random number defines random prize and assigns it to user.
     *
     * @return void
     * @throws Exception
     * @throws \Throwable
     */
    public function __invoke()
    {
        $user = User::find(Auth::id());
        $random_number = random_int(1, 3);
        switch ($random_number) {
            case 1:
                echo "assign to user random amount of money = ";
                $money = Money::first();
                $randomMoneyPrize = RandomUtility::random_float($money->start, $money->end);
                echo $randomMoneyPrize;
                DB::beginTransaction();
                if (($money->balance - $randomMoneyPrize) > 0.0) {
                    $user->money_balance += $randomMoneyPrize;
                    if ($user->save()) {
                        $money->balance -= $randomMoneyPrize;
                        if ($money->save()) {
                            DB::commit();
                            UsersPrize::create(
                                [
                                    "type" => "money",
                                    "user_id" => $user->id,
                                    "money_amount" => $randomMoneyPrize,
                                ]
                            );
                        } else {
                            DB::rollBack();
                        }
                    } else {
                        DB::rollBack();
                    }
                } else {
                    redirect(route("home"));
                }

                break;
            case 2:
                echo "assign to user random amount of points = ";
                $point = Point::first();
                $randomPointPrize = RandomUtility::random_float($point->start, $point->end);
                DB::beginTransaction();
                $user->point_balance += $randomPointPrize;
                if ($user->save()) {
                    DB::commit();
                    UsersPrize::create(
                        [
                            "type" => "points",
                            "user_id" => $user->id,
                            "points_amount" => $randomPointPrize,
                        ]
                    );
                } else {
                    DB::rollBack();
                }
                echo $randomPointPrize;
                break;
            case 3:
                echo "assign to user random prize item = ";
                $oldestPrizeId = PrizeItem::oldest("id")->first()->id;
                $latestPrizeId = PrizeItem::latest("id")->first()->id;
                $randomPrize = null;
                $randomPrizeId = null;
                while (is_null(PrizeItem::find($randomPrizeId))) {
                    $randomPrizeId = random_int($oldestPrizeId, $latestPrizeId);
                    $randomPrize = PrizeItem::find($randomPrizeId);
                }
                DB::beginTransaction();
                $randomPrize->user_id = $user->id;
                if ($randomPrize->save()) {
                    DB::commit();
                    UsersPrize::create(
                        [
                            "type" => "prize_item",
                            "prize_item_id" => $randomPrize->id,
                            "user_id" => $user->id,
                        ]
                    );
                } else {
                    DB::rollBack();
                }
                echo $randomPrize->name;
                break;
            default:
                echo "return try later message";
        }
    }

}
