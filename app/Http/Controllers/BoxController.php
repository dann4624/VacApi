<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Box;
use App\Models\Permission;
use App\Models\Type;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Kasser', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Kasser', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Box());
        $data->name = $request->name;
        $data->shelf_id = $request->shelf_id;
        $data->type_id = $request->type_id;
        $data->batch = $request->batch;

        $type = Type::where('id','=',$request->type_id)->first();
        $data->expires_at = now()->addDays($type->shelf_life);

        $data->save();

        return response('Kasse oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::where('id','=',$id)->first();
        if(!$data){
            return response('Kasse ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::where('id','=',$id)->first();
        if(!$data){
            return response('Kasse ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->shelf_id)){
            $data->shelf_id = $request->shelf_id;
        }

        if(isset($request->type_id)){
            $data->type_id = $request->type_id;
        }

        if(isset($request->batch)){
            $data->batch = $request->batch;
        }

        $data->save();

        return response('Kasse opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::where('id','=',$id)->first();
        if(!$data){
            return response('Kasse ikke fundet', 404);
        }

        $data->delete();

        return response('Kasse slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Kasse ikke fundet', 404);
        }

        $data->forceDelete();

        return response('Kasse permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Box::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Kasse ikke fundet', 404);
        }

        $data->restore();

        return response('Kasse genoprettet', 200);
    }
}
