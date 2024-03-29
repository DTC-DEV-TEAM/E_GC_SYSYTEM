<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrCreationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_creations', function (Blueprint $table) {
            $table->id();
            $table->string('status_id')->nullable();
            $table->string('campaign_id')->nullable();
            $table->string('gc_description')->nullable();
            $table->integer('gc_value')->nullable();
            $table->string('number_of_gcs')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('batch_group')->nullable();
            $table->string('po_number')->nullable();
            $table->string('po_attachment')->nullable();
            $table->string('company_id')->nullable();
            $table->string('upload_limit')->nullable();
            $table->string('store_logo')->nullable();
            $table->integer('manager_approval')->nullable();
            $table->timestamp('manager_approval_date')->nullable();
            $table->integer('accounting_approval')->nullable();
            $table->timestamp('accounting_approval_date')->nullable();
            $table->string('billing_number')->nullable();
            $table->integer('campaign_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('qr_creations');
    }
}
