<?php

namespace App\Repositories;

use App\Http\Services\TransactionService;
use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function add($transaction)
    {
        $destination_user = self::findAccountByDeposit($transaction->destination_account_number);
        $source_user = Auth::user()->account;
        return Transaction::create([
            'amount' => $transaction->amount,
            'second_password' => $source_user->secondPassword,
            'description' => $transaction->description,
            'destination_first_name' => $destination_user->firstname,
            'destination_last_name' => $destination_user->lastname,
            'destination_account_number' => $transaction->destination_account_number,
            'track_id' => TransactionService::generate_uuid(),
            'user_id' => $source_user->user_id,
            'payment_number' => TransactionService::rand(),
            'status' => 'pending',
        ]);
    }

    public  function updateSuccessful($id,$transactionResponse)
    {
        return  Transaction::query()->find($id)->update([
            'inquiry_time'=>$transactionResponse['result']->inquiryTime,
            'inquiry_date'=>$transactionResponse['result']->inquiryDate,
            'status'=>'done',
            'ref_code'=>$transactionResponse['result']->refCode,
        ]);

    }

    public  function updateUnsuccessful($id, $transactionResponse)
    {
        return Transaction::query()->find($id)->update([
            'error' => $transactionResponse['error']->code,
            'message' => $transactionResponse['error']->message,
            'status' => 'failed',
        ]);

    }

    public  function findAccountByDeposit($deposit)
    {
        return Account::query()
            ->where('deposit', '=', $deposit)->first();
    }

    public  function transactions($user_id)
    {
        return Transaction::query()->where('user_id', '=', $user_id)->get();
    }
}
