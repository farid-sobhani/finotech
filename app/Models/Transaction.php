<?php

namespace App\Models;

use App\Http\Services\TransactionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];


}
