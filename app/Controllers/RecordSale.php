<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\SaleModel;

class RecordSale extends BaseController
{
    public function index(): string
    {
        $products  = (new ProductModel())->where('stock_quantity >', 0)->orderBy('name', 'ASC')->findAll();
        $customers = (new CustomerModel())->orderBy('full_name', 'ASC')->findAll();
        return view('record_sale', ['products' => $products, 'customers' => $customers]);
    }

    public function store()
    {
        $productId  = (int) $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id') ?: null;
        $quantity   = (int) $this->request->getPost('quantity');
        $soldBy     = session()->get('user_id');

        $productModel = new ProductModel();
        $product      = $productModel->find($productId);

        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.')->withInput();
        }

        // Stock check
        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Quantity must be at least 1.')->withInput();
        }

        if ($quantity > $product['stock_quantity']) {
            return redirect()->back()->with('error',
                "Insufficient stock. Only {$product['stock_quantity']} unit(s) of \"{$product['name']}\" available."
            )->withInput();
        }

        $totalPrice = $product['price'] * $quantity;

        // Record the sale
        (new SaleModel())->insert([
            'product_id'  => $productId,
            'customer_id' => $customerId,
            'sold_by'     => $soldBy,
            'quantity'    => $quantity,
            'total_price' => $totalPrice,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        // Deduct stock
        $productModel->update($productId, [
            'stock_quantity' => $product['stock_quantity'] - $quantity,
        ]);

        return redirect()->to('/record-sale')->with('success',
            "Sale recorded! {$quantity}x \"{$product['name']}\" for ₱" . number_format($totalPrice, 2) . "."
        );
    }
}
