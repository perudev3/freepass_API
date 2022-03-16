<?php

namespace App\Http\Controllers;

use App\Events\ReservasStatusChangedEvent;
use App\Http\Resources\CategoryRestaurantsCollection;
use App\Http\Resources\RestaurantsCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Mail;
use App\Mail\SolicitudCoinAdmin;
use App\Mail\SolicitudCoinUsuario;
use App\Mail\ResetPassword;
use App\Models\tbl_categoria;
use App\User;
use App\Models\tbl_restaurante;
use App\Models\tbl_wallet;
use App\Models\tbl_eventos;
use App\Models\tbl_pais;

class WelcomeController extends Controller
{
    public function DataCustomerIfo()
    {
        $restaurantes = tbl_restaurante::with(['ciudades','pais', 'img_restaurantes', 'user'])->where('estado', 1)->get();
        $eventos = tbl_eventos::all();
        return [
            'restaurantes' => $restaurantes->where('user.categorias_id', 1),
            'discotecas' => $restaurantes->where('user.categorias_id', 2),
            'bares' => $restaurantes->where('user.categorias_id', 3),
            'restobar' => $restaurantes->where('user.categorias_id', 4),
            'eventos' => $eventos
        ];
    }

    public function DateWeek(Request $request)
    {
        $date = $request->date;
        $timestamp = strtotime($date);
        $weekday= date("l", $timestamp );
        $normalized_weekday = strtolower($weekday);
        if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
            tbl_customer_ifo::with(['ciudad','pais'])->get();
        } else {
            tbl_customer_ifo::with(['ciudad','pais'])->get();
        }
    }

    public function ViewProfile()
    {
        return view('detail_view');
    }
    
    public function DataCustomer(Request $request)
    {
        $user = Auth::user();
        $restaurante = tbl_restaurante::with(['ciudades','pais', 'img_restaurantes'])->where(
            'nombre_slug', $request->nombre_slug
        )->where('estado', 1)->first();

        $eventos = tbl_eventos::where('restaurantes_id', $restaurante->restaurantes_id)->get();
        
        return [
            'user' => $user,
            'restaurante' => $restaurante,
            'eventos' => $eventos
        ];
    }

    public function WalletUser()
    {
        $user = Auth::user();
        return tbl_wallet::with('user')->where('user_id', $user->id)->get();
        
    }

    public function RecargaCoin(Request $request)
    {
        $user = \Auth::user();
        $monto = tbl_wallet::where('user_id', $user->id)->first();

        /* $query = tbl_wallet::where('user_id', $user->id)->update([
            'wallet_monto' => $monto->wallet_monto + $request->wallet_monto,
        ]);*/

        /* Mail::to('henrydl.92@gmail.com')->send(
            new SolicitudCoinAdmin($user, $request->wallet_monto)
        ); */

        Mail::to($request->email_contact)->send(
            new SolicitudCoinUsuario($user, $request->wallet_monto)
        );
    }

    public function GetMyReservas()
    {
        $user = \Auth::user();
        return tbl_reservas::with('customer_ifo')->where('user_id', $user->id)->get();
    }

    public function GenerateQRRegular($restaurantes_id, $date)
    {
      
        $user = Auth::user();
        $limit_pass = tbl_restaurante::where('restaurantes_id', $restaurantes_id)->first();
        
        $timestamp = strtotime($date);
        $weekday= date("l", $timestamp );
        $normalized_weekday = strtolower($weekday);
        if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
            $query = tbl_reservas::where('user_id', $user->id)
                             ->where('customer_ifo_id', $customer_ifo_id)
                             ->where('reservas_fecha', $date)
                             ->first();
            if ($query == true) {
                return ['error' => 'success', 'messagge' => 'Ya genero su Pass'];
            }else{
                $count_reservas = tbl_reservas::where('reservas_fecha', $date)->get();
                while ($count_reservas->count() <= $limit_pass->customer_ifo_limite_weekend) {
                    $reserva = tbl_reservas::create([
                        'reservas_codigo'=> Str::random(6),
                        'reservas_prioridad' => 'regular',
                        'reservas_fecha' => $date,
                        'reservas_estado' => 0,
                        'user_id' => $user->id,
                        'customer_ifo_id' => $customer_ifo_id,
                    ]);
            
                    $codigo = $reserva->reservas_codigo;
            
                    if ($reserva == true) {
                        event(new ReservasStatusChangedEvent);
                        //\QrCode::format('png')->size(200)->generate($codigo, '../public/qrcodes/'.$codigo.'.png'); 
                        return view('GenerateQR.regular_QR', compact('codigo'));
                    }
                }
            }
        } else {
            $query = tbl_reservas::where('user_id', $user->id)
                             ->where('customer_ifo_id', $customer_ifo_id)
                             ->where('reservas_fecha', $date)
                             ->first();
            if ($query == true) {
                return ['error' => 'success', 'messagge' => 'Ya genero su Pass'];
            }else{
                $count_reservas = tbl_reservas::where('reservas_fecha', $date)->get();
                while ($count_reservas->count() <= $limit_pass->customer_ifo_limite_week) {
                    $reserva = tbl_reservas::create([
                        'reservas_codigo'=> Str::random(6),
                        'reservas_prioridad' => 'regular',
                        'reservas_fecha' => $date,
                        'reservas_estado' => 0,
                        'user_id' => $user->id,
                        'customer_ifo_id' => $customer_ifo_id,
                    ]);
                
                    $codigo = $reserva->reservas_codigo;
            
                    if ($reserva == true) {
                        event(new ReservasStatusChangedEvent);
                        //\QrCode::format('png')->size(200)->generate($codigo, '../public/qrcodes/'.$codigo.'.png'); 
                        return view('GenerateQR.regular_QR', compact('codigo'));
                    }
                }
            }
        }

        
    }

    public function CerrarSesion(Request $request)
    {
        $user = \Auth::user();
        User::where('id', $user->id)->update([ 'session_user' => NULL ]);
        \Auth::logout();
        return Redirect::to('/');
    }

    public function ResetPassword(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user==false) {
            return ['status' => 'error', 'message' => 'El email no existe'];
        }

        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => \Carbon\Carbon::now()
        ]);

        $tokenData = \DB::table('password_resets')->where('email', $request->email)->first();

        $link = 'https://freepass.es/password/reset/' . $tokenData->token . '?email=' . urlencode($user->email);

        $response = Mail::to($request->email)->send(
            new ResetPassword($link)
        );

        if ($link) {
            return [
                'status' => '200',
                'message' => 'Se envio correctamente'
            ];
        }
        
    }

    public function GetCategoryRestaurants($id)
    {
        $categoria=tbl_categoria::findOrfail($id);
        $restaurantes=$categoria->restaurantes()->latest()->paginate(10);

        return new CategoryRestaurantsCollection($restaurantes);
    }
    public function SearchRestaurant(Request $request)
    {
        $restaurantes=tbl_restaurante::where('nombre', 'like', '%'.$request->nombre.'%')->get();
        return new RestaurantsCollection($restaurantes);
    }
}
