<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    //
    
    public function registerCollection(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $collection = new Colections();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'symbol' => ['required','max:255'],
            'editiondate' => ['required', 'date_format:Y-m-d'],
            'cards' => ['required'],

        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'ERROR');
        }else{
            $collection = new Collection();
            $collection->name = $datos->name;
            $collection->symbol = $datos->symbol;
            $editiondate->symbol = $datos->editiondate;

            $collectionResponse = [$collection->id, $collection->name];

            try{
                $collection->save();
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Error al guardar');
            }
            foreach($request->all()['cards'] as $card){

                if(isset($card['card_id'])){            
                    $validatorExistingCards = Validator::make($card, [
                        'card_id' => ['integer', 'exists:cards,id'],
                    ]);
                    if($validatorExistingCards->fails()){
                        return ResponseGenerator::generateResponse(400, $validatorExistingCards->errors()->all(), 'El formato es invalido');
                    }else{
                        $existingCard = Card::find($card['card_id']);

                        try{
                            $collection->cards()->attach($existingCard);
                        }catch(\Exception $e){
                            return ResponseGenerator::generateResponse(400, $existingCard, 'error al guardar');
                        }
                    }
                }else{
                    $validatorNewCards = Validator::make($card, [
                        'name' => ['required', 'max:20'],
                        'description' => ['required', 'max:100'],
                    ]);
                    if($validator->fails()){
                        return ResponseGenerator::generateResponse(400, $validatorNewCards->errors()->all(), 'El formato es invalido');
                    }else{
                        $newCard = new Card();
                        $newCard->name = $card['name'];
                        $newCard->description = $card['description'];

                        try{
                            $newCard->save();    
                            $collection->cards()->attach($newCard);                        
                        }catch(\Exception $e){
                            return ResponseGenerator::generateResponse(400, '', 'Fallo al guardar la carta');
                        }
                    }
                }
            }
        }
    }
}