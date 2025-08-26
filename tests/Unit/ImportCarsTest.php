<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportCarsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_cars_from_local_file()
    {
        // Garante que não existe nada antes
        Car::truncate();

        // Executa o comando de importação
        $this->artisan('import:cars', ['--local' => true])
             ->expectsOutput('Importação concluída com sucesso!')
             ->assertExitCode(0);

        // Confirma que inseriu um carro
        $this->assertDatabaseCount('cars', 1);

        $car = Car::first();
        $this->assertNotNull($car->brand);
        $this->assertNotNull($car->model);
        $this->assertNotNull($car->price);

        $this->assertIsString($car->optionals);
        $this->assertJson($car->optionals);

        $this->assertIsString($car->fotos);
        $this->assertJson($car->fotos);

        $this->assertIsBool($car->sold);
    }

    /** @test */
    public function it_updates_existing_car_when_rerun()
    {
        Car::truncate();

       
        $this->artisan('import:cars', ['--local' => true]);

        $car = Car::first();
        $originalPrice = $car->price;

        
        $car->price += 1000;
        $car->save();

        
        $this->artisan('import:cars', ['--local' => true])
             ->expectsOutput('Importação concluída com sucesso!')
             ->assertExitCode(0);

        
        $this->assertDatabaseHas('cars', [
            'external_id' => $car->external_id,
            'price' => $originalPrice,
        ]);

        
        $updatedCar = Car::first();
        $this->assertIsBool($updatedCar->sold);
        $this->assertJson($updatedCar->optionals);
        $this->assertJson($updatedCar->fotos);
    }
}