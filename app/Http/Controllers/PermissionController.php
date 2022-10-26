<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_viewAny')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Permission::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Permissions', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_viewAny_deleted')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        return response('Ingen Funktionalitet', 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        return response('Ingen Funktionalitet', 404);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_view')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Permission::where('id','=',$id)->first();
        if(!$data){
            return response('Kasse Log ikke fundet', 404);
        }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        return response('Ingen Funktionalitet', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        return response('Ingen Funktionalitet', 404);
    }
    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        return response('Ingen Funktionalitet', 404);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'permissions_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        return response('Ingen Funktionalitet', 404);
    }
}
