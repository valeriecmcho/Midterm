<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    protected CustomerModel $model;

    public function __construct()
    {
        $this->model = new CustomerModel();
    }

    public function index(): string
    {
        $customers = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('customers', ['customers' => $customers]);
    }

    public function store()
    {
        $this->model->insert([
            'full_name'  => $this->request->getPost('full_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/customers')->with('success', 'Customer added successfully.');
    }

    public function edit(int $id): string
    {
        $customer  = $this->model->find($id);
        $customers = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('customers', ['customers' => $customers, 'editCustomer' => $customer]);
    }

    public function update(int $id)
    {
        $this->model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ]);
        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer deleted successfully.');
    }
}
