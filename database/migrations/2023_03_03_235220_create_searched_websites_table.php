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
        Schema::create('searched_websites', function (Blueprint $table) {
            $table->id();

            $table->string('name', 35)->nullable();
            $table->string('domain', 255)->nullable();
            $table->integer('search_times')->default(0);
            $table->unsignedBigInteger('first_searched_by')->nullable();
            $table->dateTime('first_searched_by_date')->nullable();
            $table->unsignedBigInteger('last_searched_by')->nullable();
            $table->dateTime('last_searched_by_date')->nullable();
            $table->integer('points')->default(0);
            $table->longText('data')->nullable();

            $table->timestamps();

            $table->foreign('first_searched_by')->references('id')->on('users');
            $table->foreign('last_searched_by')->references('id')->on('users');


            /*
            JSON DATA FORMAT
            
            '
            {
                "data": {
                    "info": {
                        "websites_title": "Title",
                        "websites_link": "link",
                        "websites_domain_name": "dm_name",
                    },
                    "performance": {
                        "image_count": "35",
                        "avarage_image_loading_speed": "3.2",
                        "banner_count": "22",
                        "avarage_banner_loading_speed": "3.1",
                        "banners&images_formats": {
                            "jpg": "false",
                            "png": "false",
                            "webp": "false",
                            "gif": "false",
                            "jpeg": "false",
                        }
                    }
                }
            }
            '
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searched_websites');
    }
};
