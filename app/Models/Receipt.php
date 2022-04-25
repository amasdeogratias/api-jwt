<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ReceiptNumber',
        'ReceiptDate',
        'ReceiptTime',
        'PartyName',
        'BillNumber',
        'BillAmount',
        'DayRate',
        'AmountPaidInFC',
        'AmountPaidInDollar',
        'TotalAmount',
        'UserID',
        'CompanyName',
        'CmpGuid',
    ];
}
