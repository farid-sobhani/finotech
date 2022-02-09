<?php

namespace App\Interfaces;

interface AccountRepositoryInterface
{
    public function findAccountById($id);
    public function create($accountRequest);
}
