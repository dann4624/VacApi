<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Type;
use Illuminate\Http\Request;

/**
 * @OA\get(
 *      path="/types",
 *      summary="Get a list of Types",
 *      description="Get a list of Types",
 *      operationId="TypesList",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Types"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/types/deleted",
 *      summary="Get a list of deleted Types",
 *      description="Get a list of deleted Types",
 *      operationId="TypesListDeleted",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Types"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/types",
 *      summary="Create a Type",
 *      description="Create a Type",
 *      operationId="TypesCreate",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Type",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Type Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="shelf_life",
 *              description="Shelf Life",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="120"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *     @OA\Parameter(
 *              name="minimum_temperature",
 *              description="Minimum Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="-60"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="maximum_temperature",
 *              description="Maximum Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="-10"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Type Created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/types/{id}",
 *      summary="Get a specific Type",
 *      description="Get a specific Type",
 *      operationId="TypesShow",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Type",
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
 *      description="Type Object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/types/{id}",
 *      summary="Update a Type",
 *      description="Update a Type",
 *      operationId="TypesUpdate",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *
 *       @OA\Parameter(
 *              name="name",
 *              description="Name of the Type",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Type Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="shelf_life",
 *              description="Shelf Life",
 *              @OA\Schema(
 *                 type="integer",
 *                 example="120"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *     @OA\Parameter(
 *              name="minimum_temperature",
 *              description="Minimum Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="-60"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="maximum_temperature",
 *              description="Maximum Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="-10"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *   @OA\Response(
 *      response=200,
 *      description="Type updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/types/{id}",
 *      summary="Delete a Type",
 *      description="Delete a Type",
 *      operationId="TypesDelete",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Type",
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
 *      description="Type deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/types/{id}/force",
 *      summary="Permanently delete a Type",
 *      description="Permanently delete a Type",
 *      operationId="TypesDeleteForce",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Type",
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
 *      description="Type permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/types/{id}/restore",
 *      summary="Restore a deleted Type",
 *      description="Restore a deleted Type",
 *      operationId="TypesRestore",
 *      tags={"Types"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Type",
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
 *      description="Type restored"
 *   ),
 * )
 */

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Typer'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Typer'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Type());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->shelf_life)){
            $data->shelf_life = $request->shelf_life;
        }

        if(isset($request->minimum_temperature)){
            $data->minimum_temperature = $request->minimum_temperature;
        }

        if(isset($request->maximum_temperature)){
            $data->maximum_temperature = $request->maximum_temperature;
        }

        $data->save();

        response()->json(['besked' => 'Type oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request,$id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Type ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Type ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->shelf_life)){
            $data->shelf_life = $request->shelf_life;
        }

        if(isset($request->minimum_temperature)){
            $data->minimum_temperature = $request->minimum_temperature;
        }

        if(isset($request->maximum_temperature)){
            $data->maximum_temperature = $request->maximum_temperature;
        }

        $data->save();

        response()->json(['besked' => 'Type opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Type ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Type slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Type ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Type permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'types_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Type::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Type ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Type genoprettet'], 200);
    }
}
