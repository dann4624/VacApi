<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Box;
use App\Models\Permission;
use App\Models\Position;
use App\Models\Type;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/boxes",
 *      summary="Get a list of Boxes",
 *      description="Get a list of Boxes",
 *      operationId="BoxesList",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Boxes"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/boxes/deleted",
 *      summary="Get a list of deleted Boxes",
 *      description="Get a list of deleted Boxes",
 *      operationId="BoxesListDeleted",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Boxes"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/boxes",
 *      summary="Create an box",
 *      description="Create an box",
 *      operationId="BoxesCreate",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="position_id",
 *              description="id of the position",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="type_id",
 *              description="id of the type",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the box",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Box Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="batch",
 *              description="Batch of the box",
 *              @OA\Schema(
 *                 type="string",
 *                 example="batch string"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Box Created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/boxes/{id}",
 *      summary="Get a specific a Box",
 *      description="Get a specific Box",
 *      operationId="BoxesShow",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="1",
 *                  minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Box object"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/boxes/name/{name}",
 *      summary="Get a specific a Box by Name",
 *      description="Get a specific Box by Name",
 *      operationId="BoxesShowByName",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Box",
 *              @OA\Schema(
 *                 type="string",
 *                 example="15",
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Box object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/boxes/{id}",
 *      summary="Update a Box",
 *      description="Update a Box",
 *      operationId="BoxesUpdate",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="id",
 *              description="id of the Box",
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
 *              name="position_id",
 *              description="id of the Position",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *
 *      @OA\Parameter(
 *              name="type_id",
 *              description="id of the Type",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                 minimum=1
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Box",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Box Name"
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *
 *      @OA\Parameter(
 *              name="batch",
 *              description="Batch of the Box",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Batch string"
 *              ),
 *              in="query",
 *              required=false
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="Box updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/boxes/{id}",
 *      summary="Delete a Box",
 *      description="Delete a Box",
 *      operationId="BoxesDelete",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box",
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
 *      description="Box deleted"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/boxes/{id}/force",
 *      summary="Permanently delete a Box",
 *      description="Permanently delete a Box",
 *      operationId="BoxesDeleteForce",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box",
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
 *      description="Box permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/boxes/{id}/restore",
 *      summary="Restore a deleted box",
 *      description="Restore a deleted box",
 *      operationId="BoxesRestore",
 *      tags={"Boxes"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Box",
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
 *      description="Box restored"
 *   ),
 * )
 */

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Kasser'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Kasser'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }
        $type = Type::where('id','=',$request->type_id)->first();

        $data = (new Box());
        $data->name = $request->name;
        $data->position_id = $request->position_id;
        $data->type_id = $request->type_id;
        $data->batch = $request->batch;
        $data->expires_at = now()->addDays($type->shelf_life);

        $data->save();

        $position = Position::where('id','=',$request->position_id)->first();
        $position->box_id = $data->id;
        $position->save();

        response()->json(['besked' => 'Kasse oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse ikke fundet'], 404);
        }

        return response()->json($data,200);
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function by_name(Request $request, $name)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::where('name','=',$name)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->position_id)){
            $data->position_id = $request->position_id;
        }

        if(isset($request->type_id)){
            $data->type_id = $request->type_id;
        }

        if(isset($request->batch)){
            $data->batch = $request->batch;
        }

        $data->save();

        if(isset($request->position_id)) {
            $position = Position::where('id', '=', $request->position_id)->first();
            $position->box_id = $id;
            $position->save();
        }

        response()->json(['besked' => 'Kasse opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Kasse slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Kasse permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'boxes_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Box::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Kasse ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Kasse genoprettet'], 200);
    }
}
