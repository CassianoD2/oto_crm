<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParameterDateRequest;
use App\Http\Services\Pmweb_Orders_Stats;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    /**
     * Instance of Service Orders.
     *
     * @var Pmweb_Orders_Stats
     */
    public $pmOrderStatsService;

    public function __construct()
    {
        $this->pmOrderStatsService = new Pmweb_Orders_Stats();
    }

    /**
     * Function to return the total of orders from a date or between dates.
     *
     * @param ParameterDateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnOrderCountByDate(Request $request)
    {
        /**
         * Para deixar o código mais simples, eu optei por colocar um Validator diretamente no Controller,
         * Porém se fosse dentro do site, com sistema de autenticação funcional (Token ou CSRFToken) eu colocaria esta
         * validação dentro de um FormRequest (php artisan make:request)
         */
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        /**
         * Comentário do Desenvolvedor:
         * Neste momento eu teria alterado a classe para funcionar com retorno em cadeia, ao inves de ser um void
         * seria interessante colocar a classe retornando ela mesma ($this) para que não se replicasse código.
         *
         * Deixei assim, pois como é parte do teste, não sabia se poderia alterado, mas deixei comentado na classe
         * de serviço: return $this;
         */
        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'totalOrders' => $this->pmOrderStatsService->getOrdersCount()
        ]);
    }

    /**
     * This function is responsible for return the revenue of the orders between dates or with a initial date.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnOrdersRevenueByDate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'ordersRevenue' => round($this->pmOrderStatsService->getOrdersRevenue(), 2)
        ]);
    }

    /**
     * This function is responsible for return the total quantities of items selled after a date or beetween dates.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnTotalQuantityItensSellByDate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'orderQuantity' => round($this->pmOrderStatsService->getOrdersQuantity(), 2)
        ]);
    }

    /**
     * This function is responsible for return the retail price of the order after a date or beetween dates.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnOrdersRetailPrice(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'orderRetailPrice' => round($this->pmOrderStatsService->getOrdersRetailPrice(), 2)
        ]);
    }

    /**
     * This function is responsible for return the average price of the orders between dates or after a date.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnOrdersAverageOrderValue(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'orderAverageValue' => round($this->pmOrderStatsService->getOrdersAverageOrderValue(), 2)
        ]);
    }

    /**
     * Return of the all statistics available to the user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnAllStatistics(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'orders' => [
                'count' => $this->pmOrderStatsService->getOrdersCount(),
                'revenue' => round($this->pmOrderStatsService->getOrdersRevenue(),2),
                'quantity' => $this->pmOrderStatsService->getOrdersQuantity(),
                'orderRetailPrice' => round($this->pmOrderStatsService->getOrdersRetailPrice(), 2),
                'orderAverageValue' => round($this->pmOrderStatsService->getOrdersAverageOrderValue(), 2),
            ]
        ]);
    }

    /**
     * Return the total of order by date using the parameters startDate and/or endDate.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countOrdersByDate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'startDate' => ['nullable', 'date_format:Y-m-d'],
            'endDate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startDate'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $payload = $request->all();

        $this->pmOrderStatsService
            ->setStartDate($payload['startDate'] ?? null);

        $this->pmOrderStatsService
            ->setEndDate($payload['endDate'] ?? null);

        return response()->json([
            'data' => $this->pmOrderStatsService->getOrdersByDate()
        ]);
    }
}
