<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\ZoneLog;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/zoneLogs",
 *      summary="Get a list of Zone Logs",
 *      description="Get a list of Zone Logs",
 *      operationId="ZoneLogsList",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Zone Logs"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/zoneLogs/deleted",
 *      summary="Get a list of deleted Zone Logs",
 *      description="Get a list of deleted Zone Logs",
 *      operationId="ZoneLogsListDeleted",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Zone Logs"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/zoneLogs/zone/{id}",
 *      summary="Get a specific Zone's logs",
 *      description="Get a specific Zone's logs",
 *      operationId="ZoneLogsZone",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone Log",
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
 *      description="Zone Log object"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/zoneLogs",
 *      summary="Create an Zone Log",
 *      description="Create an Zone Log",
 *      operationId="ZoneLogsCreate",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="zone_id",
 *              description="ID of the Zone",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="log_action_id",
 *              description="ID of the Action",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="temperature",
 *              description="Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="14.2",
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="humidity",
 *              description="Humidity",
 *              @OA\Schema(
 *                 type="number",
 *                 example="60",
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="alarm",
 *              description="Alarm Triggered",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=0,
 *                  minimum=0,
 *                  maximum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Zone Log created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/zoneLogs/{id}",
 *      summary="Get a specific Zone Log",
 *      description="Get a specific Zone Log",
 *      operationId="ZoneLogsShow",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone Log",
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
 *      description="Zone Log object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/zoneLogs/{id}",
 *      summary="Update an Zone Log",
 *      description="Update an Zone Log",
 *      operationId="ZoneLogsUpdate",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone Log",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *       @OA\Parameter(
 *              name="zone_id",
 *              description="ID of the Zone",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="log_action_id",
 *              description="ID of the Action",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="temperature",
 *              description="Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="14.2",
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="humidity",
 *              description="Humidity",
 *              @OA\Schema(
 *                 type="number",
 *                 example="60",
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="alarm",
 *              description="Alarm Triggered",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=0,
 *                  minimum=0,
 *                  maximum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="Zone Log updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/zoneLogs/{id}",
 *      summary="Delete an Zone Log",
 *      description="Delete an Zone Log",
 *      operationId="ZoneLogsDelete",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone Log",
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
 *      description="Zone Log deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/zoneLogs/{id}/force",
 *      summary="Permanently Delete an Zone Log",
 *      description="Permanently Delete an Zone Log",
 *      operationId="ZoneLogsDeleteForce",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone Log",
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
 *      description="Zone Log permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/zoneLogs/{id}/restore",
 *      summary="Restore a deleted Zone Log",
 *      description="Restore a deleted Zone Log",
 *      operationId="ZoneLogsRestore",
 *      tags={"Zone Logs"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone Log",
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
 *      description="Zone Log restored"
 *   ),
 * )
 */

class ZoneLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::orderBy('id','ASC')
            ->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Zone Logs'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::onlyTrashed()
            ->orderBy('id','ASC')
            ->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Zone Logs'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new ZoneLog());

        if(isset($request->temperature)){
            $data->temperature = $request->temperature;
        }

        if(isset($request->humidity)){
            $data->humidity = $request->humidity;
        }

        if(isset($request->alarm)){
            $data->alarm = $request->alarm;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }

        $data->save();

        response()->json(['besked' => 'Zone Log oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::where('id','=',$id)
            ->first();

        if(!$data){
            return response()->json(['besked' => 'Zone Log ikke fundet'], 404);
        }

        return response()->json($data,200);
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function zone(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::where('zone_id','=',$id)
            ->orderby('created_at', 'desc')
            ->get();

        if(!$data){
            return response()->json(['besked' => 'Zone Log ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone Log ikke fundet'], 404);
        }

        if(isset($request->data)){
            $data->temperature = $request->temperature;
        }

        if(isset($request->data)){
            $data->humidity = $request->humidity;
        }

        if(isset($request->data)){
            $data->alarm = $request->alarm;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        if(isset($request->log_action_id)){
            $data->log_action_id = $request->log_action_id;
        }

        $data->save();

        response()->json(['besked' => 'Zone Log opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone Log ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Zone Log slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone Log ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Zone Log permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'ZoneLogs_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = ZoneLog::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone Log ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Zone Log genoprettet'], 200);
    }
}
