<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Brugere', 404);
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
        $data = User::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Brugere', 404);
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
        $data = (new User());
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = hash('sha512',$request->name);
        $data->role_id = $request->role_id;
        $data->save();

        return response('Bruger oprettet med id: '.$data->id , 202);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
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
        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }
        if(isset($request->email)){
            $data->email = $request->email;
        }
        if(isset($request->password)){
            $data->password = hash('sha512',$request->password);
        }
        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }
        $data->save();
        return response('Bruger opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
        }
        $data->delete();
        return response('Bruger slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force($id)
    {
        $data = User::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
        }
        $data->forceDelete();
        return response('Bruger permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $data = User::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
        }
        $data->restore();

        return response('Bruger genoprettet', 204);
    }

    /**
     * Authenticate the user from the App.
     *
     * @return \Illuminate\Support\Collection
     */
    public function authenticate_app(Request $request)
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

        $token = Apitoken::where('target_id','=',Apitarget::where('name','=',"App")->first()->id)
            ->where('role_id','=',$user->role->id)
            ->first()
        ;

        $data = collect();
        $data->add($user);
        $data->add($token);

        return $data;
    }

    /**
     * Authenticate the user from the Admin Panel.
     *
     * @return \Illuminate\Support\Collection
     */
    public function authenticate_panel(Request $request)
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

        $token = Apitoken::where('target_id','=',Apitarget::where('name','=',"Admin-Panel")->first()->id)
            ->where('role_id','=',$user->role->id)
            ->first()
            ->load('role')
            ->load('target')
        ;

        $data = collect();
        $data->add($user);
        $data->add($token);

        return $data;
    }
}
