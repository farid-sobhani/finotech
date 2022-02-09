<?php

namespace App\Http\Controllers;

use App\Http\Services\TransactionService;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;

class TransactionController extends Controller
{
    public function transfer(TransactionRequest $transaction)
    {
        $client = Transaction::add($transaction);
        $user = Auth::user()->account;
        $res = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => Transaction::findAccountByDeposit($transaction->destination_account_number)->token,
        ])
            ->withHeaders([
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'destinationFirstname' => $client->destination_first_name,
                'destinationLastname' => $client->destination_last_name,
                'destinationNumber' => $client->destination_account_number,
                'paymentNumber' => $client->payment_number,
                'deposit' => $user->deposit,
                'sourceFirstName' => $user->firstname,
                'sourceLastName' => $user->lastname,
            ])
            ->post('https://sandboxapi.finnotech.ir/oak/v2/clients/' . $user->user_id
                . '/transferTo?trackId=' . $client->track_id);
        if ($res->serverError()) {
            return \response()->json(['error' => 'Server error'], 500);
        }
        if ($res->status() == 400) {
            $res = Transaction::updateUnsuccessful($client->id, $res->object());
            return \response()->json([$res],400);

        }
        if ($res->status() == 200) {
            $res = Transaction::updateSuccessful($client->id, $res->object());
            return \response()->json([$res],200);
        }


    }

    public function transactions()
    {
        $transactions = Transaction::transactions(Auth::id());
        return response()->json($transactions, 200);
    }


}
