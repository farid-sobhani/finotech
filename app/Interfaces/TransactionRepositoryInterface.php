<?php


namespace App\Interfaces;

interface TransactionRepositoryInterface
{
    public function updateSuccessful($id,$transactionResponse);
    public function updateUnSuccessful($id,$transactionResponse);
    public function findAccountByDeposit($deposit);
    public function transactions($user_id);
    public function add($transaction);
}
