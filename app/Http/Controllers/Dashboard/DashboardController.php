<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\SalesChart;
use App\Charts\UsersCountChart;
use App\Enums\UsersType;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\Invoice\InvoiceItemService;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
    ];

    public function __construct(
        protected readonly UserService        $userService,
        protected readonly InvoiceItemService $invoiceItemService
    )
    {
        $this->colors = collect($this->colors);
    }

    /**
     * Change the password
     * @param mixed $request
     */
    public function __invoke()
    {

        $users = $this->getUsersCountPerMonth();

        $usersChart = new UsersCountChart;
        $usersChart->labels($users->keys()->toArray());
        $usersChart->dataset(__('app.dashboard.users_count_statistics'), 'line', $users->values()->toArray())
            ->options([
                'color' => '#429ef5',
                'fill' => false,
                'borderColor' => 'rgb(75, 192, 192)',
            ]);


        $sales = $this->getSalesPerDay();
        $salesChart = new SalesChart;
        $salesChart->labels($sales->keys()->toArray());
        $salesChart->dataset(__('app.dashboard.sales_statistics'), 'bar', $sales->values()->toArray())
            ->options([
                'backgroundColor' => $this->generateColors(count($sales)),
            ]);


        $data = DashboardService::statistics();
        return view('layouts.dashboard.home', compact('data', 'usersChart', 'salesChart'));
    }

    private function getUsersCountPerMonth()
    {
        return $this->userService->getQuery(['current_year' => true])
            ->select(
            DB::raw('DATE_FORMAT(created_at, "%m-%d") as month_day'),
            DB::raw('COUNT(*) as users_count')
            )
            ->where('type', UsersType::CLIENT->value)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m-%d")'))
            ->get()->pluck('users_count', 'month_day');

    }

    private function getSalesPerDay()
    {
        return $this->invoiceItemService->getQuery(['current_year' => true])->select(
            DB::raw('DATE_FORMAT(created_at, "%m-%d") as month_day'),
            DB::raw('SUM(price) as total_price')
        )
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m-%d")'))
            ->get()->pluck('total_price', 'month_day');
    }

    public function generateColors(int $length)
    {
        // Fill another array with random values from the color collection
        return $this->colors->random($length)->all();
    }
}
