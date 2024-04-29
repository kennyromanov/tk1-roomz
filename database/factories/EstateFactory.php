<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use function Laravel\Prompts\text;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    public function binomial($start = 1, $end = 10, $step = 0.5)
    {
        $result = $start;

        while ($result < $end) {
            $roulette = rand(0, 100) / 100 < $step;
            if (!$roulette) break;

            $result++;
        }

        return $result;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isFull = $this->binomial(0, 1, 0.8);
        $isBig = $this->binomial(0, 1, 0.3);
        $isModern = $this->binomial(0, 1, 0.4);
        $isPremium = $this->binomial(0, 1, 0.2);
        $isRandom = $this->binomial(0, 1, 0.4);
        $bedroomSize = $isBig ? rand(8, 15) : rand(3, 8);
        $bathroomSize = $isBig ? rand(8, 15) : rand(3, 8);
        $livingRoomSize = $isBig ? rand(10, 25) : rand(8, 10);
        $kitchenSize = $isBig ? rand(8, 15) : rand(3, 8);
        $balconySize = $isBig ? rand(8, 15) : rand(3, 6);
        $othersSize = $isBig ? rand(2, 15) : rand(1, 3);
        $numBedrooms = $this->binomial(1, 4, 0.3);
        $numBathrooms = $this->binomial(1, 4, 0.2);
        $numLivingRooms = $this->binomial($isFull, 3, 0.2);
        $numKitchens = $this->binomial($isFull, 3, 0.2);
        $numBalconies = $this->binomial($isFull, 4, 0.2);
        $numOthers= $this->binomial(0, 3, 0.1);
        $numFloor = $this->binomial(1, 45, $isModern ? 0.8 : 0.5);
        $distanceRatio = rand(5, 20) / 10;

        $priceM2 = 400000 * $distanceRatio;
        if (!$isFull) $priceM2 *= 0.8;
        if ($isBig) $priceM2 *= 1.1;
        if ($isModern) $priceM2 *= 1.3;
        if ($isPremium) $priceM2 *= 1.2;

        $sizeArea = 0;
        $sizeArea += $numBedrooms * $bedroomSize;
        $sizeArea += $numBathrooms * $bathroomSize;
        $sizeArea += $numLivingRooms * $livingRoomSize;
        $sizeArea += $numKitchens * $kitchenSize;
        $sizeArea += $numBalconies * $balconySize;
        $sizeArea += $numOthers * $othersSize;
        if ($isPremium) $sizeArea += rand(10, 100);
        if ($isRandom) $sizeArea += rand(0, 10) / 10;

        $cityName = [
            'Алматы',
            'Астана',
            'Шимкент',
            'Караганда',
            'Костанай',
            'Семей',
            'Петропавловск',
        ][$this->binomial(0, 6, 0.7)];

        $currencyName = [
            'kzt',
            'usd',
        ][$this->binomial(0, 1, 0.2)];

        $price = $priceM2 * $sizeArea;
        $price = match ($currencyName) {
            'kzt' => round($price / 100000) * 100000,
            'usd' => round($price / 450 / 100) * 100,
        };

        $hasPicture = $this->binomial(0, 1, 0.8);

        // Setting an image
        $imageUUID = $hasPicture ? fake()->uuid() : null;
        if ($hasPicture) copy('resources/datasets/apartments/'.rand(1, 250).'.jpg', "public/uploads/{$imageUUID}.jpg");

        return [
            'price' => $price,
            'price_currency' => $currencyName,
            'address_city' => $cityName,
            'address_street' => fake()->streetName(),
            'address_house' => rand(1, 150),
            'address_apartment' => rand(1, 700),
            'num_rooms_bedrooms' => $numBedrooms,
            'num_rooms_bathrooms' => $numBathrooms,
            'num_rooms_livingrooms' => $numLivingRooms,
            'num_rooms_kitchens' => $numKitchens,
            'num_rooms_balconies' => $numBalconies,
            'num_rooms_other' => $numOthers,
            'num_area' => $sizeArea,
            'num_floor' => $numFloor,
            'descr' => fake()->text(300),
            'picture_filename' => $imageUUID,
        ];
    }
}
