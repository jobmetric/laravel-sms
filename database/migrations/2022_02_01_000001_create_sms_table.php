<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JobMetric\Sms\Enums\SmsFieldNoteTypeEnum;
use JobMetric\Sms\Enums\SmsFieldStatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('sms.tables.sms'), function (Blueprint $table) {
            $table->id();

            $table->foreignId('sms_gateway_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->nullableMorphs('smsable');

            $table->string('mobile_prefix')->index();
            $table->string('mobile')->index();

            $table->string('sender')->index()->nullable();

            $table->string('pattern')->nullable();
            $table->json('inputs')->nullable();

            $table->text('note')->nullable();

            $table->string('note_type')->default(SmsFieldNoteTypeEnum::FARSI())->index()->nullable();
            /**
             * value: farsi, latin
             * use: @extends SmsFieldNoteTypeEnum
             */

            $table->smallInteger('page')->index()->nullable();
            $table->decimal('price', 15, 3)->index()->nullable();

            $table->string('reference_id', 40)->nullable()->index();
            $table->string('reference_status', 50)->nullable()->index();
            $table->longText('reference_trace')->nullable();

            $table->string('status')->default(SmsFieldStatusEnum::DNS())->index();
            /**
             * value: dns, sent, sending, error, deliver, unknown
             * use: @extends SmsFieldStatusEnum
             */

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
        Schema::dropIfExists(config('sms.tables.sms'));
    }
};
