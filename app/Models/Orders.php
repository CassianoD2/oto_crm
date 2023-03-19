<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Orders extends Model
{
    use HasFactory;

    public function returnOrdersByDate($start = null, $end = null)
    {
        $order = DB::table('orders');

        if (!empty($start)) {
            $order = $order->whereDate('order_date', '>=' ,$start);
        }

        if (!empty($end)) {
            $order = $order->whereDate('order_date', '<=', $end);
        }

        return $order->get();
    }
}
