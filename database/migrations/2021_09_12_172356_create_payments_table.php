<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_note');
            $table->decimal('total', 9, 2);
            $table->decimal('pay_discount', 9, 2);
            $table->decimal('pay_tax', 9, 2);
            $table->decimal('paid', 9, 2);
            $table->decimal('pay_back', 9, 2);
            $table->string('pay_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
