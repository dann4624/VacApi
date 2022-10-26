<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Log;
use App\Models\Permission;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Logs', 404);
        }

        return response()->json($data);
    }

    /**
     * Display a listing of the deleted resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function deleted(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Logs', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Log());

        if(isset($request->data)){
            $data->data = $request->data;
        }

        if(isset($request->user_id)){
            $data->user_id = $request->user_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        $data->save();

        return response('Log oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::where('id','=',$id)->first();
        if(!$data){
            return response('Log ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::where('id','=',$id)->first();
        if(!$data){
            return response('Log ikke fundet', 404);
        }

        if(isset($request->data)){
            $data->data = $request->data;
        }

        if(isset($request->user_id)){
            $data->user_id = $request->user_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        $data->save();

        return response('Log opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::where('id','=',$id)->first();
        if(!$data){
            return response('Log ikke fundet', 404);
        }

        $data->delete();

        return response('Log slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Log ikke fundet', 404);
        }

        $data->forceDelete();

        return response('Log permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Log::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Log ikke fundet', 404);
        }

        $data->restore();

        return response('Log genoprettet', 200);
    }
}
