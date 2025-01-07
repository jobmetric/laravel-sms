<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('sms.tables.sms_gateway'), function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();

            $table->string('driver');
            /**
             * target class files in JobMetric\Sms\Drivers and app\Drivers\Sms
             */

            $table->json('fields')->nullable();
            $table->json('options')->nullable();
            $table->json('pricing')->nullable();

            $table->boolean('default')->default(false)->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('sms.tables.sms_gateway'));
    }
};
