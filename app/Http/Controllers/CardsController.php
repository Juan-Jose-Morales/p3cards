<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardsController extends Controller
{
   
    public function register(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $card = new Cards();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'description' => ['required','max:255'],
            'collection_id' => ['required', 'max:20','exists:collections,id'],
        ],
        [
            'name' => [
                'required' => 'El nombre de la carta es obligatorio.',
                'max' => 'El nombre de la carta es muy largo.',
            ],
            'description' => [
                'required' => 'la descripcion es obligatoria.',
                
            ],
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Fallo noo');
        }else{
             $card = new Card();
            $card->name = $datos->name;
            $card->descripcion = $datos->descripcion;
            $cardResponse = [$card->id, $card->name];

            try{
                $card->save();
                $card->collections()->attach($collection);
                return ResponseGenerator::generateResponse(200, $cardResponse, 'carta guardada correctamente');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Fallo al guardar');
            }
        }
    }

    public function addCardToTheCollection(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'card_id' => ['required', 'max:20', 'exists:cards,id'],
            'collection_id' => ['required', 'max:20', 'exists:collections,id'],
        ]);
        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Algo fue mal');
        }else{
            $card = Card::find($datos->card_id);
            $collection = Collection::find($datos->collection_id);

            try{
                $collection->cards()->attach($card);
                return ResponseGenerator::generateResponse(200, '', 'La carta se ha añadido con exito');
            }catch(\Exception $e){
                $collection->delete();
                return ResponseGenerator::generateResponse(400, '', 'ERROR hay algo mal al guardar');
            }
        }
    }

}
     
