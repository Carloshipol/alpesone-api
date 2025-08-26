<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Car;

class ImportCarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_cars_from_local_file()
    {
        Car::truncate();
        // Roda o comando de importação usando o sample.json
        Artisan::call('import:cars', ['--local' => true]);

        // Verifica se algum carro foi inserido
        $this->assertDatabaseCount('cars', 1);

        $car = Car::first();
        $this->assertNotNull($car->brand);
        $this->assertNotNull($car->model);
        $this->assertNotNull($car->price);
    }
}