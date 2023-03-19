<?php

namespace App\Http\Services;

use App\Models\Orders;
use Carbon\Carbon;

/**
 * Sumarizações de dados transacionais de pedidos.
 */
class Pmweb_Orders_Stats
{
    protected $startDate;
    protected $endDate;
    protected $ordersModel;

    public function __construct()
    {
        $this->ordersModel = new Orders();
        $this->startDate = null;
        $this->endDate = null;
    }

    /**
     * Define o período inicial da consulta.
     * @param String $date Data de início, formato `Y-m-d` (ex, 2017-08-24).
     *
     * @return void
     */
    public function setStartDate($date)
    {
        $this->startDate = $date;
        //return $this;
    }

    /**
     * Define o período final da consulta.
     *
     * @param String $date Data final da consulta, formato `Y-m-d` (ex,
     * 2017-08-24).
     *
     * @return void
     */
    public function setEndDate($date)
    {
        $this->endDate = $date;
        //return $this;
    }

    /**
     * Retorna o total de pedidos efetuados no período.
     *
     * @return integer Total de pedidos.
     */
    public function getOrdersCount()
    {
        /**
         * Aqui eu optei por retornar tudo e deixar que o PHP fizesse a contagem dos dados, pois assim poderia reutilizar
         * a função posteriormente para outras funcionalidades que somente necessitem de uma data inicial e/ou final.
         */
        return count(
            $this->ordersModel->returnOrdersByDate(
                $this->startDate,
                $this->endDate
            )
        );
    }

    /**
     * Retorna a receita total de pedidos efetuados no período.
     *
     * @return float Receita total no período.
     */
    public function getOrdersRevenue()
    {
        /**
         * Eu poderia da mesma maneira ter feito o calculo via banco de dados, porém imaginando que sobrecarregaria o banco,
         * dependendo da quantidade de registro e usuários utilizando, optei por deixar a aplicação fazer o cálculo.
         *
         * Como o Laravel retorna sempre uma collection quando é retornado uma consulta do banco de dados, optei por usar o SUM
         * Ao invés de utilizar um generator para realizar a soma.
         */
        $orders = $this->ordersModel->returnOrdersByDate(
            $this->startDate,
            $this->endDate
        );

        return $orders->sum('price');
    }

    /**
     * Retorna o total de produtos vendidos no período (soma de quantidades).
     *
     * @return integer Total de produtos vendidos.
     */
    public function getOrdersQuantity()
    {
        /**
         * Aqui é o mesmo caso da função de cima que calcula o total ganho pelos pedidos em uma determinada data, porém
         * agora ele ira retorna a quantidade de itens dentro de um determinado prazo.
         */
        $orders = $this->ordersModel->returnOrdersByDate(
            $this->startDate,
            $this->endDate
        );

        return $orders->sum('quantity');
    }

    /**
     * Retorna o preço médio de vendas (receita / quantidade de produtos).
     *
     * @return float Preço médio de venda.
     */
    public function getOrdersRetailPrice()
    {
        /**
         * Novamente aqui vou utilizar a aplicação para fazer estes cálculos.
         */
        $orders = $this->ordersModel->returnOrdersByDate(
            $this->startDate,
            $this->endDate
        );

        $revenue = $orders->sum('price');
        $quantity = $orders->sum('quantity');

        $total = $revenue / $quantity;

        return round($total, 2);
    }

    /**
     * Retorna o ticket médio de venda (receita / total de pedidos).
     *
     * @return float Ticket médio.
     */
    public function getOrdersAverageOrderValue()
    {
        /**
         * Novamente aqui vou utilizar a aplicação para fazer estes cálculos.
         */
        $orders = $this->ordersModel->returnOrdersByDate(
            $this->startDate,
            $this->endDate
        );

        $revenue = $orders->sum('price');
        $quantityOrders = $orders->count();

        $total = $revenue / $quantityOrders;

        return round($total, 2);
    }

    /**
     * Retorna uma listagem com a quantidade de pedidos por dia.
     *
     * @return array Pedidos por dia.
     */
    public function getOrdersByDate()
    {
        /*
         * Irei deixar comentado o antigo código para facilitar a identificação das modificações.
            $pedidos = $model->getPedidos();
            foreach ($pedidos as $key => $value) {
                $obj[$key][$value->order_date] = $value->order_date;
                if (in_array($value->order_date, $obj[$key])) {
                    $date[$key] = count($obj[$key]);
                }
            }
            return $date;
        */

        $orders = $this->ordersModel->returnOrdersByDate(
            $this->startDate,
            $this->endDate
        );

        $dataCount = [];

        /**
         * Usando funcionaldiade do map do collection, é muito mais chato e não teria o por que utilizar desta forma,
         * porém realizei um pequeno teste. E ficou até que entendivel. Porém algumas pessoas podem achar complicado ou
         * não entenderem a parte do ponteiro.
         */
//        $order = $orders->map(function ($item, $key) use (&$dataCount){
//            $dataFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $item->order_date)->format('Y-m-d');
//            $dataCount[$dataFormatada] = isset($dataCount[$dataFormatada]) ? $dataCount[$dataFormatada]+1 : 1;
//            return $dataFormatada;
//        });

        /**
         * Usando laço de interação
         */
        foreach ($orders as $item) {
            $dataFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $item->order_date)->format('Y-m-d');
            $dataCount[$dataFormatada] = isset($dataCount[$dataFormatada]) ? $dataCount[$dataFormatada]+1 : 1;
        }

        return $dataCount;
    }
}

