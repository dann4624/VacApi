<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = User::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Brugere', 404);
        }

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function deleted(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = User::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Brugere', 404);
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new User());


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

        return response('Bruger oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
        }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

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
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

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
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

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
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = User::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Bruger ikke fundet', 404);
        }

        $data->restore();

        return response('Bruger genoprettet', 200);
    }

    /**
     * Authenticate the user from the App.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function authenticate_app(Request $request)
    {
        $email = $request->email;
        $password =  hash('sha512',$request->password);

        $user = User::where('email',"=",$email)
            ->where('password',"=",$password)
            ->first()
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

        return response()->json($data);
    }

    /**
     * Authenticate the user from the Admin Panel.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function authenticate_panel(Request $request)
    {
        $email = $request->email;
        $password =  hash('sha512',$request->password);

        $user = User::where('email',"=",$email)
            ->where('password',"=",$password)
            ->first()
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

        return response()->json($data);
    }
}
