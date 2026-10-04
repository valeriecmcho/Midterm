<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected ProductModel $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    public function index(): string
    {
        $products = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('products', ['products' => $products]);
    }

    public function store()
    {
        $name          = $this->request->getPost('name');
        $price         = $this->request->getPost('price');
        $stock         = $this->request->getPost('stock_quantity');
        $imageFilename = null;

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $newName       = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $newName);
            $imageFilename = $newName;
        }

        $this->model->insert([
            'name'           => $name,
            'price'          => $price,
            'stock_quantity' => $stock,
            'image'          => $imageFilename,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/products')->with('success', 'Product added successfully.');
    }

    public function edit(int $id): string
    {
        $product = $this->model->find($id);
        if (! $product) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }
        $products = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('products', ['products' => $products, 'editProduct' => $product]);
    }

    public function update(int $id)
    {
        $product = $this->model->find($id);
        if (! $product) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }

        $data = [
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            // Remove old image if it exists
            if ($product['image'] && file_exists(FCPATH . 'uploads/products/' . $product['image'])) {
                unlink(FCPATH . 'uploads/products/' . $product['image']);
            }
            $newName       = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $newName);
            $data['image'] = $newName;
        }

        $this->model->update($id, $data);
        return redirect()->to('/products')->with('success', 'Product updated successfully.');
    }

    public function delete(int $id)
    {
        $product = $this->model->find($id);
        if ($product && $product['image'] && file_exists(FCPATH . 'uploads/products/' . $product['image'])) {
            unlink(FCPATH . 'uploads/products/' . $product['image']);
        }
        $this->model->delete($id);
        return redirect()->to('/products')->with('success', 'Product deleted successfully.');
    }
}
