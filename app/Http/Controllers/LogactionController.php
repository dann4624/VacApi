<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\LogAction;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/logActions",
 *      summary="Get a list of Log Actions",
 *      description="Get a list of Log Actions",
 *      operationId="LogActionsList",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Log Actions"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/logActions/deleted",
 *      summary="Get a list of deleted Log Actions",
 *      description="Get a list of deleted Log Actions",
 *      operationId="LogActionsListDeleted",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Log Actions"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/logActions",
 *      summary="Create a Log Action",
 *      description="Create a Log Action",
 *      operationId="LogActionsCreate",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Log Action",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Log Action Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Log Action created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/logActions/{id}",
 *      summary="Get a specific Log Action",
 *      description="Get a specific Log Action",
 *      operationId="LogActionsShow",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Log Action",
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
 *      description="Log Action object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/logActions/{id}",
 *      summary="Update an Log Action",
 *      description="Update an Log Action",
 *      operationId="LogActionsUpdate",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Log Action",
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
 *              description="Name of the Log Action",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Log Action Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *   @OA\Response(
 *      response=200,
 *      description="Log Action updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/logActions/{id}",
 *      summary="Delete an Log Action",
 *      description="Delete an Log Action",
 *      operationId="LogActionsDelete",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Log Action",
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
 *      description="Log Action deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/logActions/{id}/force",
 *      summary="Permanently Delete an Log Action",
 *      description="Permanently Delete an Log Action",
 *      operationId="LogActionsDeleteForce",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Log Action",
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
 *      description="Log Action permanently deleted"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/logActions/{id}/restore",
 *      summary="Restore a deleted Log Action",
 *      description="Restore a deleted Log Action",
 *      operationId="LogActionsRestore",
 *      tags={"Log Actions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Log Action",
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
 *      description="Log Action restored"
 *   ),
 * )
 */

class LogActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Log Actions'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Log Actions'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new LogAction());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'Log Action oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log Action ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log Action ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'Log Action opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log Action ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Log Action slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log Action ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Log Action permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'LogActions_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = LogAction::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Log Action ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Log Action genoprettet'], 200);
    }
}
