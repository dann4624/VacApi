<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Roller', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Roller', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Role());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('Rolle oprettet med id: '.$data->id , 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('Rolle opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }

        $data->delete();

        return response('Rolle slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }

        $data->forceDelete();

        return response('Rolle permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }

        $data->restore();

        return response('Rolle genoprettet', 200);
    }

    /**
     * Update the permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_edit_permissions')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }

        $permissions = $request->permissions;

        $data->permissions()->sync($permissions);

        return response('tilladelser opdateret', 200);
    }
}
