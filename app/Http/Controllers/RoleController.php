<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/roles",
 *      summary="Get a list of Roles",
 *      description="Get a list of Roles",
 *      operationId="RolesList",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Roles"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/roles/deleted",
 *      summary="Get a list of deleted Roles",
 *      description="Get a list of deleted Roles",
 *      operationId="RolesListDeleted",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Roles"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/roles",
 *      summary="Create a Role",
 *      description="Create a Role",
 *      operationId="RolesCreate",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Role",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Role Name",
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Role Created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/roles/{id}",
 *      summary="Get a specific  a Role",
 *      description="Get a specific Role",
 *      operationId="RolesShow",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Role Object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/roles/{id}",
 *      summary="Update a Role",
 *      description="Update a Role",
 *      operationId="RolesUpdate",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Role",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Role Name",
 *              ),
 *              in="query",
 *              required=true
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="Role updated"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/roles/{id}/permissions",
 *      summary="Update a Role's permissions",
 *      description="Update a Role's permissions",
 *      operationId="RolesUpdatePermissions",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="permissions[]",
 *              description="Array of Permission IDs",
 *              @OA\Schema(
 *                 type="array",
 *                  @OA\Items(type="integer"),
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Permissions updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/roles/{id}",
 *      summary="Delete a Role",
 *      description="Delete a Role",
 *      operationId="RolesDelete",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="ID",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=204,
 *      description="Role deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/roles/{id}/force",
 *      summary="Permanently delete a Role",
 *      description="Permanently delete a Role",
 *      operationId="RolesDeleteForce",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="ID",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=204,
 *      description="Role permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/roles/{id}/restore",
 *      summary="Restore a deleted Role",
 *      description="Restore a deleted Role",
 *      operationId="RolesRestore",
 *      tags={"Roles"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="ID",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                   minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Role restored"
 *   ),
 * )
 */

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
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::orderBy('ID','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Roller'], 404);
        }

        return response()->json($data,200);
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
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::onlyTrashed()->orderBy('ID','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Roller'], 404);
        }

        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Role());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'Rolle oprettet med ID: '.$data->ID], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $ID)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::where('ID','=',$ID)->first();
        if(!$data){
            return response()->json(['besked' => 'Rolle ikke fundet'], 404);
        }

        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $ID)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::where('ID','=',$ID)->first();
        if(!$data){
            return response()->json(['besked' => 'Rolle ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'Rolle opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $ID)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::where('ID','=',$ID)->first();
        if(!$data){
            return response()->json(['besked' => 'Rolle ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Rolle slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $ID)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::onlyTrashed()->where('ID','=',$ID)->first();
        if(!$data){
            return response()->json(['besked' => 'Rolle ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Rolle permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $ID)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::withTrashed()->where('ID','=',$ID)->first();
        if(!$data){
            return response()->json(['besked' => 'Rolle ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Rolle genoprettet'], 200);
    }

    /**
     * Update the permissions.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function permissions(Request $request, $ID)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'roles_edit_permissions')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Role::where('ID','=',$ID)->first();
        if(!$data){
            return response()->json(['besked' => 'Rolle ikke fundet'], 404);
        }

        $permissions = $request->permissions;

        $data->permissions()->sync($permissions);

        response()->json(['besked' => 'tilladelser opdateret'], 200);
    }
}
