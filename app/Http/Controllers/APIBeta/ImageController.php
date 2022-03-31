<?php

namespace App\Http\Controllers\APIBeta;

use App\Evento;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(Request $request, $evento_id)
    {
        $imagenes = $request->file('imagenes');
        if (!is_array($imagenes)) {
            $imagenes = [$imagenes];
        }
        //loop throu the array 
        for ($i = 0; $i < count($imagenes); $i++) {
            $file = $imagenes[$i];
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            Image::create([
                'evento_id' => $evento_id,
                'path' => $custom_name
            ]);
            $file->move(public_path() . '/imagenes', $custom_name);
        }
        return response()->json(['message' => 'imagenes cargada'], 200);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        //eliminar del storage
        $path = public_path() . '/imagenes/' . $image->path;
        if (file_exists($path)) {
            unlink($path);
        }
        $image->delete();

        return response()->json(['message' => 'imagen eliminada'], 200);
    }
}
