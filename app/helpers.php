<?php

use App\Models\Account;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\CashMovement;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\ExpenseMovement;
use Illuminate\Support\Facades\Auth;

if (!function_exists('record_stock_movement')) {
    function record_stock_movement($productId, $type, $quantity, $reason, $userId = null)
    {
        // 1️⃣ Find the product
        $product = Product::find($productId);
        if (!$product) {
            return false; // Stop if product not found
        }


        // ✅ Use passed user ID or logged-in user
        $performedBy = $userId ?? Auth::id();

        // 3️⃣ Record the stock movement
        StockMovement::create([
            'product_id'     => $product->id,
            'type'           => $type,
            'quantity'       => $quantity,
            'balance_before' => $product->quantity,
            'balance_after'  => $type === 'in'
                ? $product->quantity + $quantity
                : $product->quantity - $quantity,
            'reason'         => $reason,
            'user_id'        => $performedBy,
        ]);

        // 4️⃣ Update product quantity
        $product->quantity = $type === 'in'
            ? $product->quantity + $quantity
            : $product->quantity - $quantity;

        $product->save();

        return true;
    }
}

if (!function_exists('record_cash_movement')) {
    function record_cash_movement($type, $amount, $accountId, $reason = null, $userId = null)
    {
        // 1️⃣ Find the account
        $account = Account::find($accountId);

        if (!$account) {
            throw new \Exception("Account not found for ID: {$accountId}");
        }

        // 5️⃣ Determine user performing the action
        $performedBy = $userId ?? (Auth::check() ? Auth::id() : 1);

        $balanceBefore = $account->balance;
        $balanceAfter = $type === 'in'
            ? $account->balance + $amount
            : $account->balance - $amount;

        // 6️⃣ Record new cash movement
        CashMovement::create([
            'type'          => $type,
            'amount'        => $amount,
            'balance_before' => $balanceBefore,
            'balance_after'  => $balanceAfter,
            'account_id'    => $accountId,
            'reason'        => $reason,
            'user_id'       => $performedBy,
        ]);

        // 3️⃣ Adjust both balances (cash and account)
        if ($type === 'in') {
            $account->balance += $amount; // Increase account balance
        } else {
            $account->balance -= $amount; // Decrease account balance
        }

        // 4️⃣ Save updated account balance
        $account->save();
        
        return true;
    }
}
