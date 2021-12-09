<?php

use Illuminate\Database\Seeder;

class testEmpresa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tbl_restaurantes')->insert([
            'nombre' => 'Tao tao',
            'razon_social' => 'Tao SAC',
            'direccion' => 'Piura, Perú',
            'telefono' => '965522532',
            'lat' => '-4556622822626',
            'lng' => '-856015129292',
            'foto_perfil' => 'img-3ad253b7-e355-4f42-bd08-22fe9da92207.jpg',
            'ruc' => '486655526685',
            'user_id' => 5,
            'pais_id' => 1,
            'ciudades_id' => 3,
        ]);
    }
}
