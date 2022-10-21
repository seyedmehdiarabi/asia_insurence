<?php

namespace Modules\visitStatistics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\meeting\Models\Meeting;
use Modules\meeting\Repository\MeetingRepositoryInterface;
use Modules\planVisit\Repository\PlanVisitRepositoryInterface;
use Modules\visitStatistics\Models\Statistics;

class StatisticsController extends Controller
{
    public function month_visit()
    {
        $statistics = new Statistics();
        return $statistics->getMonthVisit();
    }

    public function week_visit($year = null)
    {
        $statistics = new Statistics();
        return $statistics->getWeekVisit($year);
    }


}
