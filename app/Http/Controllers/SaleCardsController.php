<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleCards;
use Validator;
use Illuminate\Support\Facades\Log;

class SaleCardsController extends Controller
{
    public function searchCard(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        Log::info('Recibiendo los datos.', ['request' => $datos]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
        ]);
        if($validator->fails()){
            Log::error('error al finalizar la validacion de los datos  ', ['fallos' => $validator->errors()->all()]);
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Something was wrong');
        }else{
            Log::info('la request  ha ido bien.', ['request' => $datos]);
            try{                
                $card = Card::where('name', 'like', '%'.$datos->name.'%')->get();
                Log::info('Estos son los resultados: ',['cartas' => $card]);
                return ResponseGenerator::generateResponse(200, $card, 'Aqui estan las cartas');
            }catch(\Exception $e){
                Log::error('La petición a la base de datos ha salido mal', ['fallo' => $e]);
                return ResponseGenerator::generateResponse(400, '', 'HAY UN ERROR');
            }
        }

    }
}
