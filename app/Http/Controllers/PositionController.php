<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Position;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/positions",
 *      summary="Get a list of Positions",
 *      description="Get a list of Positions",
 *      operationId="PositionsList",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Positions"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/positions/deleted",
 *      summary="Get a list of deleted Positions",
 *      description="Get a list of deleted Positions",
 *      operationId="PositionsListDeleted",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Positions"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/positions",
 *      summary="Create a position",
 *      description="Create a position",
 *      operationId="PositionsCreate",
 *      tags={"Positions"},
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
 *              name="name",
 *              description="Name of the Position",
 *              @OA\Schema(
 *                 type="string",
 *                 example="position Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *
 *   @OA\Response(
 *      response=200,
 *      description="API position Created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/positions/{id}",
 *      summary="Get a specific position",
 *      description="Get a specific position",
 *      operationId="PositionsShow",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Position",
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
 *      description="Position object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/positions/{id}",
 *      summary="Update a Position",
 *      description="Update a Position",
 *      operationId="PositionsUpdate",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Position",
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
 *              name="name",
 *              description="Name of the Position",
 *              @OA\Schema(
 *                 type="string",
 *                 example="position Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="box_id",
 *              description="ID of the Box",
 *              @OA\Schema(
 *                 type="integer",
 *                  nullable=true,
 *              ),
 *              required=false,
 *              in="query",
 *      ),
 *   @OA\Response(
 *      response=200,
 *      description="Position updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/positions/{id}",
 *      summary="Delete a Position",
 *      description="Delete a Position",
 *      operationId="PositionsDelete",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Position",
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
 *      description="API position deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/positions/{id}/force",
 *      summary="Permanently delete a Position",
 *      description="Permanently delete a Position",
 *      operationId="PositionsDeleteForce",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Position",
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
 *      description="Position permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/positions/{id}/restore",
 *      summary="Restore a deleted Position",
 *      description="Restore a deleted Position",
 *      operationId="PositionsRestore",
 *      tags={"Positions"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Position",
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
 *      description="Position restored"
 *   ),
 * )
 */

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Positioner'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Positionr'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Position());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }

        $data->save();

        response()->json(['besked' => 'Position oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Position ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Position ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->zone_id)){
            $data->zone_id = $request->zone_id;
        }


        $data->box_id = $request->box_id ?? null;

        $data->save();

        response()->json(['besked' => 'Position opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Position ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Position slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Position ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Position permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'Positions_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Position::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Position ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Position genoprettet'], 200);
    }
}
