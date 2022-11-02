<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\BoxLog;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/boxLogs",
 *      summary="Get a list of Box Logs",
 *      description="Get a list of Box Logs",
 *      operationId="BoxLogsList",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Box Logs"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/boxLogs/deleted",
 *      summary="Get a list of deleted box logs",
 *      description="Get a list of deleted box logs",
 *      operationId="BoxLogsListDeleted",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Box Logs"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/boxLogs",
 *      summary="Create a Box Log",
 *      description="Create a Box Log",
 *      operationId="BoxLogsCreate",
 *      tags={"Box Logs"},
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
 *     @OA\Parameter(
 *              name="box_id",
 *              description="ID of the Box",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *     @OA\Parameter(
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
 *     @OA\Parameter(
 *              name="zone_id",
 *              description="ID of the Zone",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *     @OA\Parameter(
 *              name="position_id",
 *              description="ID of the Position",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Box Log created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/boxLogs/{id}",
 *      summary="Update a Box Log",
 *      description="Update a Box Log",
 *      operationId="BoxLogsShow",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box Log",
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
 *      description="Box Log object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/boxLogs/{id}",
 *      summary="Update a Box Log",
 *      description="Update a Box Log",
 *      operationId="BoxLogsUpdate",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *     @OA\Parameter(
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
 *     @OA\Parameter(
 *              name="box_id",
 *              description="ID of the Box",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *     @OA\Parameter(
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
 *     @OA\Parameter(
 *              name="zone_id",
 *              description="ID of the Zone",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *     @OA\Parameter(
 *              name="position_id",
 *              description="ID of the Position",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=false
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="Box Log updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/boxLogs/{id}",
 *      summary="Delete a Box Log",
 *      description="Delete a Box Log",
 *      operationId="BoxLogsDelete",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box Log",
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
 *      description="Box Log deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/boxLogs/{id}/force",
 *      summary="Permanently delete a Box Log",
 *      description="Permanently delete a Box Log",
 *      operationId="BoxLogsDeleteForce",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box Log",
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
 *      description="Box Log permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/boxLogs/{id}/restore",
 *      summary="Restore a deleted Box Log",
 *      description="Restore a deleted Box Log",
 *      operationId="BoxLogsRestore",
 *      tags={"Box Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box Log",
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
 *      description="Box Log restored"
 *   ),
 * )
 */

class BoxLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Kasse Logs'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Kasse Logs'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new BoxLog());

        if(isset($request->box_id)){
            $data->box_id = $request->box_id;
        }

        if(isset($request->user_id)){
            $data->user_id = $request->user_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }

        if(isset($request->position_id)){
            $data->position_id = $request->position_id;
        }

        $data->save();

        response()->json(['besked' => 'Kasse Log oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse Log ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse Log ikke fundet'], 404);
        }

        if(isset($request->box_id)){
            $data->box_id = $request->box_id;
        }

        if(isset($request->user_id)){
            $data->user_id = $request->user_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }

        if(isset($request->position_id)){
            $data->position_id = $request->position_id;
        }

        $data->save();

        response()->json(['besked' => 'Kasse Log opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse Log ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Kasse Log slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse Log ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Kasse Log permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxLogs_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Boxlog::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse Log ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Kasse Log genoprettet'], 200);
    }
}
