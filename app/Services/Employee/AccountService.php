<?php

namespace App\Services\Employee;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;

class AccountService
{
    public function preRequisite(Request $request): array
    {
        return [];
    }

    public function findByUuidOrFail(Employee $employee, string $uuid): Account
    {
        return Account::query()
            ->whereHasMorph(
                'accountable',
                [Contact::class],
                function ($q) use ($employee) {
                    $q->whereId($employee->contact_id);
                }
            )
            ->whereUuid($uuid)
            ->getOrFail(trans('employee.account.account'));
    }

    public function create(Request $request, Employee $employee): Account
    {
        \DB::beginTransaction();

        $account = Account::forceCreate($this->formatParams($request, $employee));

        $employee->contact->accounts()->save($account);

        $account->addMedia($request);

        \DB::commit();

        return $account;
    }

    private function formatParams(Request $request, Employee $employee, Account $account = null): array
    {
        $formatted = [
            'name' => $request->name,
            'alias' => $request->alias,
            'number' => $request->number,
            'bank_details' => [
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'bank_code1' => $request->bank_code1,
                'bank_code2' => $request->bank_code2,
                'bank_code3' => $request->bank_code3,
            ],
        ];

        return $formatted;
    }

    public function update(Request $request, Employee $employee, Account $account): void
    {
        \DB::beginTransaction();

        $account->forceFill($this->formatParams($request, $employee, $account))->save();

        $account->updateMedia($request);

        \DB::commit();
    }

    public function deletable(Employee $employee, Account $account): void
    {
        //
    }
}
