<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Car;

class CarApiTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_lists_cars()
    {
        Car::factory()->count(3)->create();

        $response = $this->getJson('/api/cars');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data'
                 ]);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_filters_cars_by_brand()
    {
        Car::factory()->create(['brand' => 'Toyota']);
        Car::factory()->create(['brand' => 'Honda']);

        $response = $this->getJson('/api/cars?brand=Toyota');

        $response->assertStatus(200)
                 ->assertJsonFragment(['brand' => 'Toyota'])
                 ->assertJsonMissing(['brand' => 'Honda']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_a_single_car()
    {
        $car = Car::factory()->create();

        $response = $this->getJson("/api/cars/{$car->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $car->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_car()
    {
        $payload = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'external_id' => '1',
            'price' => 100000
        ];

        $response = $this->postJson('/api/cars', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['brand' => 'Toyota']);

        $this->assertDatabaseHas('cars', ['brand' => 'Toyota', 'model' => 'Corolla']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_updates_a_car()
    {
        $car = Car::factory()->create([
            'brand' => 'Honda',
            'model' => 'Civic'
        ]);

        $payload = ['model' => 'Civic Updated'];

        $response = $this->putJson("/api/cars/{$car->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['model' => 'Civic Updated']);

        $this->assertDatabaseHas('cars', ['id' => $car->id, 'model' => 'Civic Updated']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_a_car()
    {
        $car = Car::factory()->create();

        $response = $this->deleteJson("/api/cars/{$car->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}