<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Services\TransactionService;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function register(AccountRequest $accountRequest)
    {
     $account= Account::create([
            'user_id' => Auth::id(),
            'firstname' => $accountRequest->firstname,
            'lastname' => $accountRequest->lastname,
            'deposit' => $accountRequest->deposit,
            'phone' => $accountRequest->phone,
            'token' => TransactionService::generate_uuid(),
            'created_at' => \time()
        ]);

      return response()->json(['message'=>'account created successfully',$account],200);
    }

    public function account()
    {
        $account=Account::findAccountById(Auth::id());
        return response()->json([$account],200);
    }

}
