<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('cus_name',100);
            $table->string('cus_add',500);
            $table->string('cus_city',50);
            $table->string('cus_state',50);
            $table->string('cus_postcode',50);
            $table->string('cus_country',50);
            $table->string('cus_phone',50);
            $table->string('cus_fax',50);

            $table->string('ship_name',100);
            $table->string('ship_add',100);
            $table->string('ship_city',100);
            $table->string('ship_state',100);
            $table->string('ship_postcode',100);
            $table->string('ship_country',100);
            $table->string('ship_phone',50);




            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
