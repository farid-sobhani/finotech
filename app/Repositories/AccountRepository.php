<?php

namespace App\Repositories;

use App\Http\Services\TransactionService;
use App\Interfaces\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountRepository implements AccountRepositoryInterface
{
    public function findAccountById($id)
    {
        return Account::query()->find($id);
    }

    public function create($accountRequest)
    {
      return  Account::create([
            'user_id' => Auth::id(),
            'firstname' => $accountRequest->firstname,
            'lastname' => $accountRequest->lastname,
            'deposit' => $accountRequest->deposit,
            'phone' => $accountRequest->phone,
            'bankName' => $accountRequest->bankName,
            'second_password' => $accountRequest->second_password,
            'token' => TransactionService::generate_uuid(),
        ]);
    }


}
