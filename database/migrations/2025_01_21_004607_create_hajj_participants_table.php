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
        Schema::create('hajj_participants', function (Blueprint $table) {
            $table->uuid('id')->primary;
            $table->uuid('hajj_database_id');

            $table->foreign('hajj_database_id')
            ->references('id')
            ->on('hajj_databases')
            ->onDelete('cascade');
            
            //Participant Picture
            $table->string('picture')->nullable(); // To store the picture file path

            //Participant Registration Details
            $table->string('file_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->integer('no')->nullable();
            $table->string('group_code')->nullable();
            $table->string('status')->nullable();
            $table->date('registration_date')->nullable();
            $table->time('registration_time')->nullable();
            $table->string('package')->nullable();
            $table->string('package_code')->nullable();
            $table->string('room_type')->nullable();
            
            //Participant Details
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('ic_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->integer('age')->nullable(); // This will enforce NOT NULL
            $table->string('gender')->nullable();
            $table->string('race')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('marriage_status')->nullable();
            $table->string('job')->nullable();
            $table->string('job_sector')->nullable();

            //Participant Address
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('postcode')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            
            //Waris
            $table->json('waris')->nullable();

            //Hajj Details
            $table->string('hajj_registration_no')->nullable();
            $table->string('th_account_no')->nullable();
            $table->string('month_hajj_registration')->nullable();
            $table->string('year_hajj_registration')->nullable();

            //Survey & Wakil
            $table->string('representative')->nullable();
            $table->string('media_survey')->nullable();

            //Clothing Size
            $table->string('shirt_size')->nullable();
            $table->string('kurta_size')->nullable();
            $table->string('kopiah_size')->nullable();

            //Remarks
            $table->text('remarks_1')->nullable();
            $table->text('remarks_2')->nullable();
            $table->text('remarks_3')->nullable();

            //Family Members
            $table->json('family_member')->nullable();            ;

            // Bayaran
            $table->decimal('package_price', 10, 2)->nullable(); // Price of the package
            $table->decimal('discount', 10, 2)->nullable(); // Discount applied
            $table->decimal('price_after_discount', 10, 2)->nullable(); // Calculated after discount
            $table->decimal('wang_naik_haji', 10, 2)->nullable(); // money from TH
            $table->decimal('upgrade_khemah_khas', 10, 2)->nullable(); // Special tent upgrade
            $table->decimal('upgrade', 10, 2)->nullable(); // Other upgrades
            $table->decimal('total', 10, 2)->nullable(); // Total amount
            $table->json('payment_made')->nullable()->nullable(); // JSON field for multiple payments
            $table->decimal('total_payment', 10, 2)->nullable(); // Sum of all payments
            $table->decimal('payment_left', 10, 2)->nullable(); // Remaining payment
            $table->text('payment_remarks')->nullable(); // Payment remarks

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hajj_participants');
    }
};
