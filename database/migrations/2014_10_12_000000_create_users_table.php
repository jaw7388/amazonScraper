<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
//**/ Mercadolibre data /**/
            $table->string('ml_username')->nullable();
            $table->string('token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('ml_id')->nullable();
            $table->string('ml_nickname')->nullable();
            $table->string('ml_name')->nullable();
            $table->string('ml_avatar')->nullable();
            $table->integer('expires_at')->nullable();
//*************************/
            $table->text('price_table')->nullable();
            $table->text('weight_table')->nullable();
            $table->text('taxes_table')->nullable();
            $table->boolean('taxes_amazon')->default(false);
            $table->string('shipping_type')->default('gold_pro');
            $table->boolean('shipping_free')->default(false);
            $table->integer('shipping_cost')->default(0);
            $table->integer('mercadolibre_fee')->nullable();
            $table->string('post_type')->default('gold_pro');
            $table->boolean('stock_available')->default(true);
            $table->integer('stock_days')->default(10);
            $table->boolean('warranty_available')->default(false);
            $table->integer('warranty_days')->default(0);
            $table->boolean('forbiden_brands_scanner')->default(false);
            $table->text('post_description');
            $table->text('post_images')->nullable();
            $table->text('post_synonymous')->nullable();
            $table->text('forbiden_brands_list')->nullable();
//*************************/
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
