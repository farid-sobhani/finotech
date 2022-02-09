<?php

namespace App\Models;

use Facade\FlareClient\Time\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function findAccountById($id)
    {
    return Account::query()->find($id);
    }
}
