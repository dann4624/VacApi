<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Zone::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Zoner', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Zone::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Zoner', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Zone());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('Zone oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('Zone opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

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
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

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
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Zone::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Zone ikke fundet', 404);
        }

        $data->restore();

        return response('Zone genoprettet', 200);
    }

    /**
     * Authenticate the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
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

        $token = Apitoken::where('target_id',"=",Apitarget::where('name','=',"Zone-Controller")->first()->id)->first();

        return $token;
    }
}
