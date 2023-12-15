<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends Controller
{
    public function index ()
    {
        $users=Participant::all ();

        return view ('participant.participant',compact ('users'));

    }
    public function add ()
    {
        $users=Participant::all ();

        return view ('participant.add_user',compact ('users'));

    }
    public function store ( Request $request )
    {
        $validate = $request->validate ([
            "first_name" => "required|min:3|max:100|" ,
            "chance_number" => "integer|between:1,1000|required"
        ]);

        if (!Participant::where('first_name',$request['first_name'])->exists()){

            $newParticipant = new Participant ;
            $newParticipant->first_name = $request ["first_name"];
            $newParticipant->number_of_chance = $request ["chance_number"];
            $newParticipant ->save ();
        }
        else{
            $participant = Participant::where('first_name',$request['first_name'])->first();
            $participant->first_name = $request ["first_name"];
            $participant->number_of_chance = $participant->number_of_chance + $request ["chance_number"];
            $participant ->save ();

        }

        $users=Participant::all ();


        return redirect ()->back () ;



    }

    public function lottery (  )
    {
        $winner=Participant::inRandomOrder()->first();
        if (!$winner){
            $users=Participant::all ();
            return view ('participant.participant',compact ('users'));
        }
        $winner->number_of_chance = $winner->number_of_chance -1 ;
        $winnerName=$winner->first_name;
        $winner->save();
        if ($winner->number_of_chance<=0){
            $winner->delete();
        }

        $users=Participant::all ();


        return view ('participant.participant',compact ('users','winnerName'));



    }
}
