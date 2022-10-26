<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\LogAction;
use App\Models\Permission;
use Illuminate\Http\Request;

class LogActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Log Actions', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Log Actions', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new LogAction());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('Log Action oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::where('id','=',$id)->first();
        if(!$data){
            return response('Log Action ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::where('id','=',$id)->first();
        if(!$data){
            return response('Log Action ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('Log Action opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::where('id','=',$id)->first();
        if(!$data){
            return response('Log Action ikke fundet', 404);
        }

        $data->delete();

        return response('Log Action slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Log Action ikke fundet', 404);
        }

        $data->forceDelete();

        return response('Log Action permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logActions_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = LogAction::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Log Action ikke fundet', 404);
        }

        $data->restore();

        return response('Log Action genoprettet', 200);
    }
}
