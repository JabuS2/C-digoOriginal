<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletRetainedBalancesTable extends Migration
{
    public function up()
    {
        Schema::create('wallet_retained_balances', function (Blueprint $table) {
            $table->id();
            $table->float('retained_balance');
            $table->uuid('wallet_id');
            $table->timestamps();

            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallet_retained_balances');
    }
}

