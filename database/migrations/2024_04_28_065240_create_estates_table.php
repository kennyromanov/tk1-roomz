<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $dirUploads = 'public/uploads';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id()->primary();
            $table->timestamps();
            $table->integer('price');
            $table->enum('price_currency', ['kzt', 'usd'])->default('kzt');
            $table->string('address_city', 64)->nullable(false);
            $table->string('address_street', 128)->nullable(false);
            $table->string('address_house', 32);
            $table->string('address_apartment', 32);

            $table->tinyInteger('num_rooms_bedrooms')
                ->unsigned()->default(0)->nullable(false);
            $table->tinyInteger('num_rooms_bathrooms')
                ->unsigned()->default(0)->nullable(false);
            $table->tinyInteger('num_rooms_livingrooms')
                ->unsigned()->default(0)->nullable(false);
            $table->tinyInteger('num_rooms_kitchens')
                ->unsigned()->default(0)->nullable(false);
            $table->tinyInteger('num_rooms_balconies')
                ->unsigned()->default(0)->nullable(false);
            $table->tinyInteger('num_rooms_other')
                ->unsigned()->default(0)->nullable(false);
            $table->float('num_area')->default(0)
                ->nullable(false)->comment('Area in m2');
            $table->tinyInteger('num_floor')
                ->unsigned()->default(0)->nullable(false)->comment('Floor in the facility');

            $table->string('descr', 1024);
            $table->uuid('picture_filename')->nullable();


            // Alters

            $table->index('descr');


            // Other

            if (!is_dir($this->dirUploads)) mkdir($this->dirUploads);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');

        $files = glob($this->dirUploads.'/*.*');

        foreach ($files as $file)
            if (is_file($file))
                unlink($file);

        if (is_dir($this->dirUploads)) rmdir($this->dirUploads);
    }
};
