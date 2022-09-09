<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Currence;
use App\Models\Wallet;
use App\Models\Transaction;

class UserWalletController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $wallets = Wallet::all();
        $currences = Currence::all();
        $transactions = Transaction::all();

        return response()->json([
            'users' => $users,
            'wallets' => $wallets,
            'currences' => $currences,
            'transactions' => $transactions
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getBalance(Request $request)
    {
        $validations = [
            'walletId' => 'required|numeric|not_in:0',
        ];

        $this->failedValidation($request, $validations);

        $wallet = Wallet::find($request->walletId);

        if (!$wallet) {
            return response()->json([
                'message' => "Not user wallet",
            ])->setStatusCode(400);
        }

        return response()->json([
            'balance' => $wallet->balance,
            'currency_name' => $wallet->currency_name,
        ]);
    }

    /**
     * Show the form for creating a new transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validations = [
            'walletId' => 'required|numeric|not_in:0',
            'type' => 'required|in:debit,credit',
            'value' => 'required|numeric|not_in:0',
            'currence' => 'required|in:USD,RUB',
            'reason' => 'required|in:stock,refund',
        ];

        $this->failedValidation($request, $validations);

        $wallet = Wallet::find($request->walletId);

        if (!$wallet) {
            return response()->json([
                'message' => "Not user wallet",
            ])->setStatusCode(400);
        }

        $balance = $wallet->balance;

        if ($wallet->currency_name === $request->currence) {
            $balance +=  $request->value;
        } else {
            $currence = Currence::where('name', $request->currence)->where('convert_name', $wallet->currency_name)->first();

            if (!$currence) {
                return response()->json([
                    'message' => "Not currence $request->currence to $wallet->currency_name",
                ])->setStatusCode(400);
            }

            $balance += $request->value * $currence->value;
        }

        Transaction::create([
            'wallet_id' => $wallet->id,
            'value' => $request->value,
            'currency_name' => $request->currence,
            'type' => $request->type,
            'reason' => $request->reason,
        ]);
        

        $wallet->balance = $balance;
        $wallet->save();

        return response()->json([
            'balance' => $wallet->balance,
            'currency_name' => $wallet->currency_name,
        ]);
    }
}
