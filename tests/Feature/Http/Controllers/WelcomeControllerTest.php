<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\tbl_categoria;
use App\Models\tbl_ciudades;
use App\Models\tbl_pais;
use App\Models\tbl_restaurante;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testSearchRestaurant()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $pais = factory(tbl_pais::class)->create();
        $categoria = factory(tbl_categoria::class)->create();
        $ciudad = factory(tbl_ciudades::class)->create();
        $restaurantes = factory(tbl_restaurante::class, 10)->create([
            'user_id' => $user->id,
            'pais_id' => $pais->pais_id,
            'categorias_id' => $categoria->categorias_id,
            'ciudades_id' => $ciudad->ciudades_id
        ]);
        //seleccionar elemento 5 del array restaurantes
        //$restaurante=$restaurantes->random();

        $response = $this->json('GET', "/api/restaurante/search?nombre={$restaurantes[5]->nombre}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'slug',
                        'razon_social',
                        'direccion',
                        'telefono',
                        'lat',
                        'lng',
                        'foto_perfil',
                        'ruc',
                        'usuario',
                        'pais',
                        'ciudad',
                        'categoria',
                        'img_restaurantes',
                        'estado'
                    ]
                ]
            ]);
    }
}
