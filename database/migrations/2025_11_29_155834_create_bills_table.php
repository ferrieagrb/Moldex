<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // the billed user
            $table->decimal('amount', 12, 2);
            $table->string('description')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['unpaid','paid','overdue'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('issued_by')->nullable(); // admin user id who issued
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // issued_by can reference users as well, optional FK
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
