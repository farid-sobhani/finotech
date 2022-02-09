<?php

namespace App\Http\Controllers;

use App\Http\Services\TransactionService;
use App\Interfaces\TransactionRepositoryInterface;
use App\Models\User;
use Facade\FlareClient\Time\Time;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;

class TransactionController extends Controller
{
    private $repo;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->repo = $transactionRepository;
    }

    public function transfer(TransactionRequest $transaction)
    {
        $client = $this->repo->add($transaction);
        $user = Auth::user()->account;
        $bank = $this->repo->findAccountByDeposit($transaction->destination_account_number)->bankName;
        $authorization = $this->repo->findAccountByDeposit($transaction->destination_account_number)->token;

        switch ($bank) {
            case "parsian":
                $res = TransactionService::transferToParsian($transaction, $client, $user, $authorization);
                break;
            case "keshavarzi":
                $res = TransactionService::transferToKeshavarzi($transaction, $client, $user, $authorization);

                break;
            case "ayande":
                $res = TransactionService::transferToAyande($transaction, $client, $user, $authorization);

                break;
        }

        if ($res->serverError()) {
            return \response()->json(['error' => 'Server error'], 500);
        }
        if ($res->status() == 400) {
            $res = $this->repo->updateUnSuccessful($client->id, $res->object());
            return \response()->json([$res], 400);

        }
        if ($res->status() == 200) {
            $res = $this->repo->updateSuccessful($client->id, $res->object());
            return \response()->json([$res], 200);
        }


    }

    public function transactions()
    {
        $transactions = $this->repo->transactions(Auth::id());
        return response()->json($transactions, 200);
    }


}
