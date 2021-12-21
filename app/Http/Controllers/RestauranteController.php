<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\tbl_restaurante;
use App\Models\img_restaurante;
use App\Models\tbl_zonas;
use App\Models\img_zonas;
use App\User;
use App\Models\tbl_eventos;
use App\Models\tbl_listas;
use App\Models\tbl_invitados;
use App\Models\tbl_lista_code;
use App\Models\tbl_wallet;
use App\Models\tbl_reservas;

class RestauranteController extends Controller
{

    use AuthenticatesUsers;

    public function Information()
    {
        $user = \Auth::user();
        return tbl_restaurante::with('img_restaurantes')->where('user_id', $user->id)->first();
    }

    public function RegisterDataIfo(Request $request) 
    {
        $user = \Auth::user(); 
        $tbl_restaurante = tbl_restaurante::where('user_id', $user->id)->first(); 

        if ($tbl_restaurante == true) {
                $validator = \Validator::make($request->all(),[
                    'nombre' => 'required',
                    'razon_social' => 'required',
                    'direccion' => 'required',
                    'telefono' => 'required',
                    'lat' => 'required',
                    'lng' => 'required',
                    'ruc' => 'required',
                    'pais_id' => 'required',
                    'ciudades_id' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }

                $tbl_restaurante= tbl_restaurante::where('user_id', $user->id)->update([
                    'nombre' => $request->nombre,
                    'nombre_slug' => str_replace(' ', '', $request->nombre),
                    'razon_social' => $request->razon_social,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'ruc' => $request->ruc,
                    'pais_id' => $request->pais_id,
                    'ciudades_id' => $request->ciudades_id
                ]);    
                $perfil = $request->file('foto_perfil');
                $cont = 0;
                foreach($perfil as $img){
                    $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
                    if  ($cont === 0){
                        $perfil_restaurante = tbl_restaurante::where('user_id', $user->id)->update([
                            'foto_perfil' => $custom_name,
                        ]);
                    }else{
                        break;
                    }
                    $img->move(public_path().'/foto',$custom_name);
                    $cont++;
                }
                $imgs = $request->file('url_img');
                $cont = 0;
                foreach($imgs as $img){
                    $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
                    $imgs_restaurante = img_restaurante::where('restaurantes_id', $tbl_restaurante)->update([
                        'url_img' => $custom_name,
                    ]);
                    $img->move(public_path().'/img_restaurantes',$custom_name);
                    $cont++;
                }

                if ($imgs_restaurante==true) {
                    return ['status' =>'success', 'message' =>'Su Registro se actualizó correctamente'];
                }else{
                    return ['status' =>'error', 'message' =>'Ocurrio un Error'];
                }
        }else{
            
            $validator = \Validator::make($request->all(),[
                    'nombre' => 'required',
                    'razon_social' => 'required',
                    'direccion' => 'required',
                    'telefono' => 'required',
                    'lat' => 'required',
                    'lng' => 'required',
                    'ruc' => 'required',
                    'pais_id' => 'required',
                    'ciudades_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            
            $perfil = $request->file('foto_perfil');
            $cont = 0;
            foreach($perfil as $img){
                $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
                if  ($cont === 0){
                    $tbl_restaurante = tbl_restaurante::create([
                        'nombre' => $request->nombre,
                        'nombre_slug' => str_replace(' ', '', $request->nombre),
                        'razon_social' => $request->razon_social,
                        'direccion' => $request->direccion,
                        'telefono' => $request->telefono,
                        'lat' => $request->lat,
                        'lng' => $request->lng,
                        'ruc' => $request->ruc,
                        'user_id'=>$user->id,
                        'pais_id' => $request->pais_id,
                        'ciudades_id' => $request->ciudades_id,
                        'foto_perfil' => $custom_name
                    ]);
                }else{
                    break;
                }
                $img->move(public_path().'/foto',$custom_name);
                $cont++;
            }

            $imgs = $request->file('url_img');
            $cont = 0;
            foreach($imgs as $img){
                $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
                $imgs_restaurante = img_restaurante::create([
                    'url_img' => $custom_name,
                    'restaurantes_id' => $tbl_restaurante->restaurantes_id,
                ]);
                $img->move(public_path().'/img_restaurantes',$custom_name);
                $cont++;
            }

    
            if ($imgs_restaurante==true) {
                return ['status' =>'success', 'message' =>'Se Registro correctamente'];
            }else{
                return ['status' =>'error', 'message' =>'Ocurrio un Error'];
            }  
        }
        
        
    }

    public function DataListas()
    {
        $user = \Auth::user();
        $restaurante = tbl_restaurante::where('user_id', $user->id)->first();
        return tbl_lista_code::with('data_restaurante')->where('restaurantes_id', $restaurante->restaurantes_id)->get();
    }

    public function DataInvitados($lista_codes_id)
    {
        return tbl_invitados::with('user_regulares')->where('lista_codes_id', $lista_codes_id)->get();
    }

    public function GenerateLink(Request $request)
    {
        $user = \Auth::user();
        $restaurante = tbl_restaurante::where('user_id', $user->id)->first();
        $codigo_invitacion = Str::random(6);

        tbl_lista_code::create([
            'nombre' => $request->nombre,
            'codigo_invitacion' => $codigo_invitacion,
            'restaurantes_id' => $restaurante->restaurantes_id,
        ]);

        $link = "http://127.0.0.1:8000/".$restaurante->nombre_slug."/".$codigo_invitacion.'/register_invitados';
        //$link = "https://freepass.es/".$restaurante->nombre_slug."/".$codigo_invitacion.'/register_invitados';

        return [
            'status' => 'success',
            'link' => $link
        ];
    }

    public function RegisterListaInvitados(Request $request,$name_restaurante, $codigo_invitacion)
    {
        $validator = \Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefono' => 'required',
            'dni' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $verificacion_codigo = tbl_lista_code::where('codigo_invitacion', $codigo_invitacion)->first();
        if ($verificacion_codigo == true) {
            $date = Carbon::now();
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'id_rol'=> 3
            ]);

            tbl_invitados::create([
                'lista_codes_id'=>$codigo_invitacion,
                'telefono' => $request['telefono'],
                'dni' => $request['dni'],
                'status' =>0,
                'user_id' => $user->id,
                'lista_codes_id' => $verificacion_codigo->lista_codes_id
            ]);

            tbl_wallet::create([
                'wallet_fecha' => $date->format('Y-m-d'),
                'wallet_monto' => 50,
                'user_id' => $user->id,
            ]);

            if ($user == true) {
                $this->guard()->login($user);
                return view('customer.aceptar_invitacion', compact('name_restaurante','codigo_invitacion'));
            }
        }else{
            return ['message' => 'NO existe ese codigo de lista'];
        }

        
    }

    public function AceptarInvitacion()
    {
        $user = \Auth::user();
        $status_invitacion = tbl_invitados::where('user_id', $user->id)->first();
        if ($status_invitacion->status == 1) {
            return ['message' => 'Usted ya aceptó la invitación'];
        }else {
            $query = tbl_invitados::where('user_id', $user->id)->update([
                'status' => 1,
            ]);
    
            if ($query == true) {
                return ['message' => 'Gracias por estar aceptar la invitación'];
            }
        }
        
    }


    public function ListZonas()
    {
        $user = \Auth::user();
        $restaurante = tbl_restaurante::where('user_id', $user->id)->first();
        return tbl_zonas::with('img_zonas')->where('restaurantes_id', $restaurante->restaurantes_id)->get();
    }

    public function RegisterZonas(Request $request)
    {
        $user = \Auth::user(); 
        $tbl_restaurante = tbl_restaurante::where('user_id', $user->id)->first(); 

        $validator = \Validator::make($request->all(),[
                'nombre' => 'required',
                'tipo_ambiente' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $portada = $request->file('portada');
        $cont = 0;
        foreach($portada as $img){
            $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
            if  ($cont === 0){
                $tbl_zonas = tbl_zonas::create([
                    'nombre' => $request->nombre,
                    'portada' => $custom_name,
                    'tipo_ambiente' => $request->tipo_ambiente,
                    'restaurantes_id' => $tbl_restaurante->restaurantes_id
                ]);
            }else{
                break;
            }
            $img->move(public_path().'/zonas_portada',$custom_name);
            $cont++;
        }

        $imgs = $request->file('url_img');
        $cont = 0;
        foreach($imgs as $img){
            $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
            $imgs_zonas = img_zonas::create([
                'url_img' => $custom_name,
                'zonas_id' => $tbl_zonas->zonas_id,
            ]);
            $img->move(public_path().'/img_zonas',$custom_name);
            $cont++;
        }


        if ($imgs_zonas==true) {
            return ['status' =>'success', 'message' =>'Se Registro correctamente'];
        }else{
            return ['status' =>'error', 'message' =>'Ocurrio un Error'];
        }  
    }


    public function ListEventos()
    {
        $user_id = \Auth::user()->id_rol;
        $restaurante = tbl_restaurante::where('user_id', $user_id)->first();
        return tbl_eventos::where('restaurantes_id', $restaurante->restaurantes_id)->get();
    }

    public function ListZonasRestaurante()
    {
        $user = \Auth::user();
        $restaurante = tbl_restaurante::where('user_id', $user->id)->first();

        return tbl_zonas::where('restaurantes_id', $restaurante->restaurantes_id)->get();
    }

    public function RegisterEventos(Request $request)
    {
        $user_id = \Auth::user()->id_rol;
        $restaurante = tbl_restaurante::where('user_id', $user_id)->first();
        if ($user_id == 3) {
            $lista_evento = json_decode($request->form_lista, true);
            if ($lista_evento != null) {
                $evento = tbl_eventos::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'fecha' => $request->fecha,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'status' => 1,
                    'restaurantes_id' => $restaurante->restaurantes_id,
                ]); 
                $perfil = $request->file('img_eventos');
                $cont = 0;
                if (is_array($perfil) || is_object($perfil))
                {
                    foreach($perfil as $img){
                        $custom_name = 'img-'.Str::uuid()->toString().'.'.$img->getClientOriginalExtension();
                        if  ($cont === 0){
                            $img_evento = tbl_eventos::where('eventos_id', $evento->eventos_id)->update([
                                'img_eventos' => $custom_name,
                            ]);
                        }else{
                            break;
                        }
                        $img->move(public_path().'/img_eventos',$custom_name);
                        $cont++;
                    } 
                }
                for ($i=0; $i < count($lista_evento); $i++) {                     
                    $listas = tbl_listas::create([
                        'nombre' => $lista_evento[$i]['nombre'],
                        'status' => 1,
                        'precio' => $lista_evento[$i]['precio'],
                        'cant_pases' => $lista_evento[$i]['cant_pases'],
                        'personas_x_mesa' => $lista_evento[$i]['personas_x_mesa'],
                        'descripcion' => $lista_evento[$i]['descripcion'],
                        'fecha_inicia' => $lista_evento[$i]['fecha_inicia'],
                        'hora_inicia' => $lista_evento[$i]['hora_inicia'],
                        'fecha_fin' => $lista_evento[$i]['fecha_fin'],
                        'hora_fin' => $lista_evento[$i]['hora_fin'],
                        'tipo_lista' => $lista_evento[$i]['type_lista'],
                        'zonas_id' => $lista_evento[$i]['zonas_id'],
                        'lista_codes_id' => $lista_evento[$i]['lista_codes_id'] ? $lista_evento[$i]['lista_codes_id'] : null,
                        'eventos_id' => $evento->eventos_id,
                    ]);                     
                }

                if ($listas == true) {
                    return [
                        'status' => 'success',
                    ];
                }
            }
        }        
    }

    public function Reservas()
    {
        $user = \Auth::user();
        if ($user->id_rol==1 || $user->id_rol==2) {
            return tbl_reservas::with('user')->where('customer_ifo_id', $customer_ifo_id->customer_ifo_id)->get();
        }else{
            return ['message' => 'no autorizado'];
        }  
    }

    public function ReservasStatus(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'reservas_codigo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $codigo = $request->reservas_codigo;
        $date = Carbon::now();
        $query = tbl_reservas::where('reservas_codigo', $codigo)->first();
        if ($query->reservas_codigo == $codigo) {
            if ($query->reservas_fecha == $date) {
                if ($query->reservas_estado == 0) {
                    $status_update = tbl_reservas::where('reservas_codigo', $codigo)->update([
                        'reservas_estado' => 1
                    ]);

                    $reserva = tbl_reservas::with('user')->where('reservas_codigo', $codigo)->first();

                    if ($status_update == true) {
                        return [
                            'user' => $reserva,
                            'status' => 'success', 
                            'message' => 'Bienvenido al restaurante'
                        ];
                    }else{
                        return ['status' => 'error', 'message' => 'Problemas en actualizar el resgistro'];
                    }
                }else{
                    return ['status' => 'success', 'message' => 'El cliente ya esta en el restaurantes'];
                }
            }else{
                return ['status' => 'error', 'message' => 'Su reserva no está programada para hoy'];
            }           
        }else{
            return ['status' => 'error', 'message' => 'Este código no existe'];
        }
        
    }


    public function ReservasData(Request $request)
    {
        return tbl_restaurante::with('eventos')->where('restaurantes_id', $request->restaurantes_id)->get();
    }
    
}
