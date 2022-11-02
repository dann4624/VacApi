<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/permissions",
 *      summary="Get a list of permissions",
 *      description="Get a list of permissions",
 *      operationId="PermissionsList",
 *      tags={"Permissions"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Permissions"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/permissions/{id}",
 *      summary="Get a specific  an permission",
 *      description="Get a specific permission",
 *      operationId="PermissionsShow",
 *      tags={"Permissions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the permission",
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
 *      response=200,
 *      description="Permission object"
 *   ),
 * )
 *
 */

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
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Permission::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Permissions'], 404);
        }
        return response()->json($data,200);
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
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Permission::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse Log ikke fundet'], 404);
        }

        return response()->json($data,200);
    }
}
