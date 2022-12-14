<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Hylder', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Hylder', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Shelf());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }

        $data->save();

        return response('Hylde oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::where('id','=',$id)->first();
        if(!$data){
            return response('Hylde ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::where('id','=',$id)->first();
        if(!$data){
            return response('Hylde ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }

        $data->save();

        return response('Hylde opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::where('id','=',$id)->first();
        if(!$data){
            return response('Hylde ikke fundet', 404);
        }

        $data->delete();

        return response('Hylde slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Hylde ikke fundet', 404);
        }

        $data->forceDelete();

        return response('Hylde permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'shelves_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Shelf::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Hylde ikke fundet', 404);
        }

        $data->restore();

        return response('Hylde genoprettet', 200);
    }
}
