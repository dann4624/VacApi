<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/tokens",
 *      summary="Get a list of API Tokens",
 *      description="Get a list of API Tokens",
 *      operationId="TokensList",
 *      tags={"API - Tokens"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example="1"),
 *              @OA\Property(property="token", type="string", example="Bedste API Token"),
 *              @OA\Property(property="created_at", type="string", format="datetime", example="31-03-2022 02:28:47"),
 *              @OA\Property(property="updated_at", type="string", format="datetime", example="31-03-2022 03:15:46"),
 *              example={
 *                  {"id":1,"token":"Bedste API Token","created_at":"31-03-2022 02:28:47","updated_at":"31-03-2022 03:15:46"},
 *                  {"id":2,"token":"Bedste API Token","created_at":"31-03-2022 02:28:47","updated_at":"31-03-2022 03:15:46"},
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Ingen API Token"
 *      )
 * )
 *
 * @OA\post(
 *      path="/tokens",
 *      summary="Create a API Token",
 *      description="Create a API Token",
 *      operationId="TokensCreate",
 *      tags={"API - Tokens"},
 *      @OA\Parameter(
 *              name="target_id",
 *              description="ID of the API Target",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="role_id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Response(
 *          response=202,
 *          description="API Token created"
 *      )
 * )
 *
 * * @OA\get(
 *      path="/tokens/deleted",
 *      summary="Get a list of deleted  API Tokens",
 *      description="Get a list of deleted  API Tokens",
 *      operationId="TokensListDeleted",
 *      tags={"API - Tokens"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example="1"),
 *              @OA\Property(property="token", type="string", example="Bedste API Token"),
 *              @OA\Property(property="created_at", type="string", format="datetime", example="31-03-2022 02:28:47"),
 *              @OA\Property(property="updated_at", type="string", format="datetime", example="31-03-2022 03:15:46"),
 *              example={
 *                  {"id":1,"token":"Bedste API Token","created_at":"31-03-2022 02:28:47","updated_at":"31-03-2022 03:15:46"},
 *                  {"id":2,"token":"Bedste API Token","created_at":"31-03-2022 02:28:47","updated_at":"31-03-2022 03:15:46"},
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Ingen API Token"
 *      )
 * )
 *
 * @OA\get(
 *      path="/tokens/{id}",
 *      summary="Get a specific  API Token",
 *      description="Get a specific  API Token",
 *      operationId="TokensShow",
 *      tags={"API - Tokens"},
 *      @OA\Parameter(
 *              name="id",
 *              description="API Token ID",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example="1"),
 *              @OA\Property(property="token", type="string", example="Bedste API Token"),
 *              @OA\Property(property="created_at", type="string", format="datetime", example="31-03-2022 02:28:47"),
 *              @OA\Property(property="updated_at", type="string", format="datetime", example="31-03-2022 03:15:46"),
 *              example={
 *                  {"id":1,"token":"Bedste API Token","created_at":"31-03-2022 02:28:47","updated_at":"31-03-2022 03:15:46"}
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Ingen API Token"
 *      )
 * )
 *
 * @OA\put(
 *      path="/tokens/{id}",
 *      summary="Update an API Token",
 *      description="",
 *      operationId="TokensUpdate",
 *      tags={"API - Tokens"},
 *      @OA\Parameter(
 *              name="id",
 *              description="API Token ID",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="target_id",
 *              description="ID of the API Target",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="role_id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *   security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="API Token updated"
 *   )
 * )
 *
 * @OA\delete(
 *      path="/tokens/{id}",
 *      summary="Delete an API Token",
 *      description="Delete an API Token",
 *      operationId="TokensDelete",
 *      tags={"API - Tokens"},
 *      @OA\Parameter(
 *              name="id",
 *              description="API Token ID",
 *              @OA\Schema(
 *                 type="integer",
 *                  example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *   security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=204,
 *      description="API Token deleted"
 *   )
 * )
 *
 * @OA\delete(
 *      path="/tokens/{id}/force",
 *      summary="Permanently delete an API Tokens",
 *      description="Permanently delete an API Tokens",
 *      operationId="TokensDeleteForce",
 *      tags={"API - Tokens"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Token",
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
 *      description="API Token Permanently Deleted"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/tokens/{id}/restore",
 *      summary="Restore a deleted API Token",
 *      description="Restore a deleted API Token",
 *      operationId="tokensRestore",
 *      tags={"API - Tokens"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the API Token",
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
 *      description="API Token restored"
 *   ),
 * )
 *
 */

class ApitokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'],403);
        }

        $data = Apitoken::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen API Tokens'],404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitoken::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede API Tokens'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Apitoken());

        $timestamp = now();
        $data->token = hash('sha512',$timestamp);

        if(isset($request->target_id)){
            $data->target_id = $request->target_id;
        }

        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }

        if(isset($request->expires_at)){
            $data->expire_at = $request->expires_at;
        }

        $data->save();

        response()->json(['besked' => 'API Token oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Token ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Token ikke fundet'], 404);
        }

        if(isset($request->target_id)){
            $data->target_id = $request->target_id;
        }

        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }

        if(isset($request->expires_at)){
            $data->expire_at = $request->expires_at;
        }

        $data->save();

        response()->json(['besked' => 'API Token opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Token ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'API Token slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitoken::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Token ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'API Token permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'tokens_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Apitoken::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'API Token ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'API Token genoprettet'], 200);
    }
}
