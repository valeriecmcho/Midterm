<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table         = 'sales';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['product_id', 'customer_id', 'sold_by', 'quantity', 'total_price', 'created_at'];
    protected $useTimestamps = false;

    /**
     * Get all sales joined with product, customer, and staff names.
     */
    public function getSalesHistory()
    {
        return $this->db->table('sales s')
            ->select('s.id, p.name AS product_name, c.full_name AS customer_name, u.full_name AS staff_name, s.quantity, s.total_price, s.created_at')
            ->join('products p', 'p.id = s.product_id', 'left')
            ->join('customers c', 'c.id = s.customer_id', 'left')
            ->join('users u', 'u.id = s.sold_by', 'left')
            ->orderBy('s.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
