<?php

namespace App\Jobs;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncCarsFromJson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $response = Http::get(' https://hub.alpes.one/api/v1/integrator/export/1902');
        if ($response->failed()) return;

        $cars = $response->json();

        foreach ($cars as $data) {
            // Gerar hash do JSON do carro
            $jsonHash = md5(json_encode($data));

          
            $car = Car::where('external_id', $data['id'])->first();

           
            if (!$car) {
                Car::create([
                    'external_id' => $data['id'],
                    'brand' => $data['brand'],
                    'model' => $data['model'],
                    'version' => $data['version'] ?? null,
                    'year_model' => $data['year']['model'] ?? null,
                    'year_build' => $data['year']['build'] ?? null,
                    'doors' => $data['doors'] ?? null,
                    'board' => $data['board'] ?? null,
                    'chassi' => $data['chassi'] ?? null,
                    'transmission' => $data['transmission'] ?? null,
                    'km' => $data['km'] ?? null,
                    'description' => $data['description'] ?? null,
                    'sold' => $data['sold'] == "1",
                    'category' => $data['category'] ?? null,
                    'url_car' => $data['url_car'] ?? null,
                    'old_price' => $data['old_price'] ?? null,
                    'price' => $data['price'] ?? null,
                    'color' => $data['color'] ?? null,
                    'fuel' => $data['fuel'] ?? null,
                    'photos' => json_encode($data['fotos'] ?? []),
                    'json_hash' => $jsonHash,
                    'created_at' => $data['created'] ?? now(),
                    'updated_at' => $data['updated'] ?? now(),
                ]);
            } else {
              
                if ($car->json_hash !== $jsonHash) {
                    $car->update([
                        'brand' => $data['brand'],
                        'model' => $data['model'],
                        'version' => $data['version'] ?? null,
                        'year_model' => $data['year']['model'] ?? null,
                        'year_build' => $data['year']['build'] ?? null,
                        'doors' => $data['doors'] ?? null,
                        'board' => $data['board'] ?? null,
                        'chassi' => $data['chassi'] ?? null,
                        'transmission' => $data['transmission'] ?? null,
                        'km' => $data['km'] ?? null,
                        'description' => $data['description'] ?? null,
                        'sold' => $data['sold'] == "1",
                        'category' => $data['category'] ?? null,
                        'url_car' => $data['url_car'] ?? null,
                        'old_price' => $data['old_price'] ?? null,
                        'price' => $data['price'] ?? null,
                        'color' => $data['color'] ?? null,
                        'fuel' => $data['fuel'] ?? null,
                        'photos' => json_encode($data['fotos'] ?? []),
                        'json_hash' => $jsonHash,
                        'updated_at' => $data['updated'] ?? now(),
                    ]);
                }
            }
        }
    }
}