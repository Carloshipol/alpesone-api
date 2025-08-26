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
        $this->artisan('import:cars', ['--local' => true])
             ->expectsOutput('Importação concluída com sucesso!')
             ->assertExitCode(0);

        // Verifica se algum carro foi inserido
        $this->assertDatabaseCount('cars', 1);

        $car = Car::first();

        $this->assertNotNull($car->brand);
        $this->assertNotNull($car->model);
        $this->assertNotNull($car->price);

        // Verifica campos opcionais
        $this->assertIsString($car->optionals);
        $this->assertJson($car->optionals);

        $this->assertIsString($car->fotos);
        $this->assertJson($car->fotos);

        // Verifica booleano
        $this->assertIsBool($car->sold);
    }

    /** @test */
    public function it_updates_existing_car_when_rerun()
    {
        Car::truncate();

        // Primeira importação
        $this->artisan('import:cars', ['--local' => true]);

        $car = Car::first();
        $originalPrice = $car->price;

        // Simula alteração do JSON: muda o preço diretamente no banco
        $car->price = $originalPrice + 1000;
        $car->save();

        // Roda novamente o comando
        $this->artisan('import:cars', ['--local' => true])
             ->expectsOutput('Importação concluída com sucesso!')
             ->assertExitCode(0);

        // Confirma que o valor foi atualizado para o original do JSON
        $this->assertDatabaseHas('cars', [
            'external_id' => $car->external_id,
            'price' => $originalPrice,
        ]);

        // Continua verificando os campos opcionais e booleanos
        $updatedCar = Car::first();
        $this->assertIsBool($updatedCar->sold);
        $this->assertJson($updatedCar->optionals);
        $this->assertJson($updatedCar->fotos);
    }
}