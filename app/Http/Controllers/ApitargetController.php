<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/targets",
 *      summary="Get a list of API Targets",
 *      description="Get a list of API Targets",
 *      operationId="TargetsList",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of API Targets"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/targets/deleted",
 *      summary="Get a list of deleted API Targets",
 *      description="Get a list of deleted API Targets",
 *      operationId="TargetsListDeleted",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted API Targets"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/targets",
 *      summary="Create an API Target",
 *      description="Create an API Target",
 *      operationId="TargetsCreate",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the API Target",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Target Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="API Target created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/targets/{id}",
 *      summary="Get a specific API Target",
 *      description="Get a specific API Target",
 *      operationId="TargetsShow",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Target",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="API Target object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/targets/{id}",
 *      summary="Update an API Target",
 *      description="Update an API Target",
 *      operationId="TargetsUpdate",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Target",
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
 *              description="Name of the API Target",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Target Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="API Target updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/targets/{id}",
 *      summary="Delete an API Target",
 *      description="Delete an API Target",
 *      operationId="TargetsDelete",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Target",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=204,
 *      description="API Target deleted"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/targets/{id}/force",
 *      summary="Permanently delete an API Target",
 *      description="Permanently delete an API Target",
 *      operationId="TargetsDeleteForce",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Target",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=204,
 *      description="API Target permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/targets/{id}/restore",
 *      summary="Restore a deleted API Target",
 *      description="Restore a deleted API Target",
 *      operationId="TargetsRestore",
 *      tags={"API - Targets"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Target",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="API Target restored"
 *   ),
 * )
 */

class ApitargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen API Targets'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede API Targets'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Apitarget());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'API Target oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Target ikke fundet'], 404);
        }

        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Target ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'API Target opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Target ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'API Target slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Target ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'API Target permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitarget::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Target ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'API Target genoprettet'], 200);
    }

}
