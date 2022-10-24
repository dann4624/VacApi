<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Zone::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Zoner', 404);
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function deleted()
    {
        $data = Zone::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Zoner', 404);
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = (new Zone());
        $data->name = $request->name;
        $data->save();

        return response('Zone oprettet med id: '.$data->id , 202);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }
        $data->name = $request->name;
        $data->save();
        return response('Zone opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }
        $data->delete();
        return response('Zone slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force($id)
    {
        $data = Zone::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }
        $data->forceDelete();
        return response('Zone permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $data = Zone::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }
        $data->restore();

        return response('Zone genoprettet', 204);
    }

    /**
     * Authenticate the yser.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password =  hash('sha512',$request->password);

        $user = User::where('email',"=",$email)
            ->where('password',"=",$password)
            ->first();
        ;

        if(!$user){
            return response('Bruger ikke fundet', 404);
        }

        $token = Apitoken::where('target_id',"=",Apitarget::where('name','=',"Zone-Controller")->first()->id)->first();

        return $token;
    }
}
