<?php

namespace App\Http\Services;

use Webpatser\Uuid\Uuid;

class TransactionService
{

    public static function generate_uuid()
    {
        $uuid=Uuid::generate()->string;
        return $uuid;
    }
    public static function rand(){
        $rand=rand(1000000000,9999999999);
        return $rand;
    }

}
