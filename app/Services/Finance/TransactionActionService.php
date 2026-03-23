<?php

namespace App\Services\Finance;

use App\Actions\Finance\CancelTransaction;
use App\Models\Finance\Transaction;
use App\Models\Finance\TransactionRecord;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionActionService
{
    public function cancel(Request $request, Transaction $transaction)
    {
        if (! $transaction->isCancellable()) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_operation')]);
        }

        $request->merge(['cancellation_remarks' => 'Cancelled']);

        (new CancelTransaction)->execute($request, $transaction);
    }
}
