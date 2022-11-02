<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Log;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/logs",
 *      summary="Get a list of User Logs",
 *      description="Get a list of User Logs",
 *      operationId="LogsList",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of User Logs"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/logs/deleted",
 *      summary="Get a list of deleted User Logs",
 *      description="Get a list of deleted User Logs",
 *      operationId="LogsListDeleted",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted User Logs"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/logs",
 *      summary="Create an User Log",
 *      description="Create an User Log",
 *      operationId="LogsCreate",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="log_action_id",
 *              description="ID of the Log Action",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="user_id",
 *              description="ID of the User",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="data",
 *              description="Data",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Data"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="User Log created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/logs/{id}",
 *      summary="Get a specific User Log",
 *      description="Get a specific User Log",
 *      operationId="LogsShow",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="1"
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="User Log object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/logs/{id}",
 *      summary="Update an User Log",
 *      description="Update an User Log",
 *      operationId="LogsUpdate",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="log_action_id",
 *              description="ID of the Log Action",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="user_id",
 *              description="ID of the User",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="data",
 *              description="Data",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Data"
 *              ),
 *              in="query",
 *              required=true
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="User Log updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/logs/{id}",
 *      summary="Delete an User Log",
 *      description="Delete an User Log",
 *      operationId="LogsDelete",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="1"
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=204,
 *      description="User Log deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/logs/{id}/force",
 *      summary="Permanently delete an User Log",
 *      description="Permanently delete an User Log",
 *      operationId="LogsDeleteForce",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="1"
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=204,
 *      description="User Log permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/logs/{id}/restore",
 *      summary="Restore a deleted User Log",
 *      description="Restore a deleted User Log",
 *      operationId="LogsRestore",
 *      tags={"User Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="1"
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="User Log restored"
 *   ),
 * )
 */

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Logs'], 404);
        }

        return response()->json($data,200);
    }

    /**
     * Display a listing of the deleted resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function deleted(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Logs'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Log());

        if(isset($request->data)){
            $data->data = $request->data;
        }

        if(isset($request->user_id)){
            $data->user_id = $request->user_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        $data->save();

        response()->json(['besked' => 'Log oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log ikke fundet'], 404);
        }

        if(isset($request->data)){
            $data->data = $request->data;
        }

        if(isset($request->user_id)){
            $data->user_id = $request->user_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        $data->save();

        response()->json(['besked' => 'Log opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Log slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Log permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'logs_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Log::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Log genoprettet'], 200);
    }
}
