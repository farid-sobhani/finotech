<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Services\TransactionService;
use App\Interfaces\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $repo;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->repo = $accountRepository;
    }

    public function register(AccountRequest $accountRequest)
    {
        $account = $this->repo->create($accountRequest);
        return response()->json(['message' => 'account created successfully', $account], 200);
    }

    public function account()
    {
        $account = $this->repo->findAccountById(Auth::id());
        return response()->json([$account], 200);
    }

}
