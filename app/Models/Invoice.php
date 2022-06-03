<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'InvoiceNo',
        'InvoiceDate',
        'CustomerName',
        'CustomerCode',
        'ItemName',
        'ItemPrice',
        'ItemQty',
        'TotalAmount',
    ];
}
