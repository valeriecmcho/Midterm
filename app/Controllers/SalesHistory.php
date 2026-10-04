<?php

namespace App\Controllers;

use App\Models\SaleModel;

class SalesHistory extends BaseController
{
    public function index(): string
    {
        $sales = (new SaleModel())->getSalesHistory();
        return view('sales_history', ['sales' => $sales]);
    }
}
