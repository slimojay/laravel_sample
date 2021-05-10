<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string("bidder", 255);
            $table->integer("for");
            $table->string("contact", 100);
            $table->string("email", 100);
            $table->string("home_address", 255);
            $table->string("annual_income_after_tax", 100);
            $table->integer("marital_status");
            $table->integer("current_num_of_kids");
            $table->longtext("about_bidder");
            $table->integer("bid_status");
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
        Schema::dropIfExists('offers');
    }
}
