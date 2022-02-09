<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Webpatser\Uuid\Uuid;

class TransactionService
{

    public static function generate_uuid()
    {
        $uuid = Uuid::generate()->string;
        return $uuid;
    }

    public static function rand()
    {
        $rand = rand(1000000000, 9999999999);
        return $rand;
    }

    public static function transferToParsian($transaction, $client, $user, $authorization)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $authorization,
        ])
            ->withHeaders([
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'destinationFirstname' => $client->destination_first_name,
                'destinationLastname' => $client->destination_last_name,
                'destinationNumber' => $client->destination_account_number,
                'secondPassword' => $user->second_password,
            ])
            ->post('https://sandboxapi.finnotech.ir/oak/v2/clients/' . $user->user_id
                . '/transferTo?trackId=' . $client->track_id);
    }

    public static function transferToKeshavarzi($transaction, $client, $user, $authorization)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $authorization,
        ])
            ->withHeaders([
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'destinationFirstname' => $client->destination_first_name,
                'destinationLastname' => $client->destination_last_name,
                'destinationNumber' => $client->destination_account_number,
                'deposit' => $user->deposit,
                'sourceFirstName' => $user->firstname,
                'sourceLastName' => $user->lastname,
            ])
            ->post('https://sandboxapi.finnotech.ir/oak/v2/clients/' . $user->user_id
                . '/transferTo?trackId=' . $client->track_id);
    }

    public static function transferToAyande($transaction, $client, $user, $authorization)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $authorization,
        ])
            ->withHeaders([
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'destinationFirstname' => $client->destination_first_name,
                'destinationLastname' => $client->destination_last_name,
                'destinationNumber' => $client->destination_account_number,
            ])
            ->post('https://sandboxapi.finnotech.ir/oak/v2/clients/' . $user->user_id
                . '/transferTo?trackId=' . $client->track_id);
    }

}
