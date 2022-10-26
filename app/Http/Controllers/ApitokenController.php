<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use Illuminate\Http\Request;

class ApitokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen API Tokens', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede API Tokens', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Apitoken());

        $timestamp = now();
        $data->token = hash('sha512',$timestamp);

        if(isset($request->target_id)){
            $data->target_id = $request->target_id;
        }

        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }

        if(isset($request->expires_at)){
            $data->expire_at = $request->expires_at;
        }

        $data->save();

        return response('API Token oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }

        if(isset($request->target_id)){
            $data->target_id = $request->target_id;
        }

        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }

        if(isset($request->expires_at)){
            $data->expire_at = $request->expires_at;
        }

        $data->save();

        return response('API Token opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }

        $data->delete();

        return response('API Token slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }

        $data->forceDelete();

        return response('API Token permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitoken::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }

        $data->restore();

        return response('API Token genoprettet', 200);
    }
}
