<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Typer', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Typer', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Type());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->shelf_life)){
            $data->shelf_life = $request->shelf_life;
        }

        if(isset($request->minimum_temperature)){
            $data->minimum_temperature = $request->minimum_temperature;
        }

        if(isset($request->maximum_temperature)){
            $data->maximum_temperature = $request->maximum_temperature;
        }

        $data->save();

        return response('Type oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request,$id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::where('id','=',$id)->first();
        if(!$data){
            return response('Type ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::where('id','=',$id)->first();
        if(!$data){
            return response('Type ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->shelf_life)){
            $data->shelf_life = $request->shelf_life;
        }

        if(isset($request->minimum_temperature)){
            $data->minimum_temperature = $request->minimum_temperature;
        }

        if(isset($request->maximum_temperature)){
            $data->maximum_temperature = $request->maximum_temperature;
        }

        $data->save();

        return response('Type opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::where('id','=',$id)->first();
        if(!$data){
            return response('Type ikke fundet', 404);
        }

        $data->delete();

        return response('Type slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Type ikke fundet', 404);
        }

        $data->forceDelete();

        return response('Type permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Type::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Type ikke fundet', 404);
        }

        $data->restore();

        return response('Type genoprettet', 200);
    }
}
