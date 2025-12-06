<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateTicketsTable extends Migration
{
    public function up()
        {
            Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('category')->nullable();
            $table->enum('status', ['open', 'claimed', 'closed'])->default('open');
            $table->boolean('high_priority')->default(false);
            $table->foreignId('assigned_admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            });
        }
    public function down()
        {
            Schema::dropIfExists('tickets');
        }
}