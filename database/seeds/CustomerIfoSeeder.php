<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerIfoSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_customer_ifos')->insert([
            'customer_ifo_nombre' => 'Restaurant Peña Show Señor Perú',
            'customer_ifo_lat' => -4625625258,
            'customer_ifo_lng' => -8856223336785,
            'customer_ifo_descripcion' => 'Restaurante de comida criolla con gran variedad para nuestros comensales',
            'customer_ifo_direccion' => 'Mz. V Lt. 4B, Zona Industrial II, C. 6, Piura',
            'customer_ifo_telefono' => '073206129',
            'customer_ifo_foto' => 'avatar-0f1de68e-a29f-4c3e-bd83-5a281092fd52.jpg',
            'customer_ifo_limite_weekend' => 20,
            'customer_ifo_limite_week' => 20,
            'user_id' => 5,
            'pais_id' => 1,
            'ciudades_id' => 3
        ]);
    }
}
