<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function run(callable $callback)
    {
        return DB::transaction($callback);
    }
}
