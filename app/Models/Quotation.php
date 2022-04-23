<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quot_no',
        'quot_date',
        'customer_name',
        'mobile',
        'fax',
        'contact_person',
        'country',
        'payment_method',
        'notes',
    ];
}
