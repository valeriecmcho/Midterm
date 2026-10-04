<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\SaleModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $productModel  = new ProductModel();
        $customerModel = new CustomerModel();
        $saleModel     = new SaleModel();

        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        $todaySales = $saleModel->db->table('sales')
            ->selectSum('total_price', 'total')
            ->selectSum('quantity', 'qty')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->get()->getRowArray();

        $totalProducts  = $productModel->countAll();
        $totalCustomers = $customerModel->countAll();
        $totalTx        = $saleModel->db->table('sales')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->countAllResults();

        $lowStock     = $productModel->where('stock_quantity <=', 10)->orderBy('stock_quantity', 'ASC')->findAll(5);
        $recentSales  = $saleModel->getSalesHistory();
        $recentSales  = array_slice($recentSales, 0, 10);

        return view('dashboard', [
            'todaySales'     => $todaySales['total'] ?? 0,
            'totalTx'        => $totalTx,
            'totalProducts'  => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'lowStock'       => $lowStock,
            'recentSales'    => $recentSales,
        ]);
    }
}
