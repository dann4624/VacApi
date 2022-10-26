<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 * path="/login",
 * summary="Sign in",
 * description="Login by email, password",
 * operationId="authLogin",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *       @OA\Property(property="persistent", type="boolean", example="true"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *     )
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
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen API Targets', 404);
        }

        return response()->json($data);
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
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede API Targets', 404);
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_create')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = (new Apitarget());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('API Target oprettet med id: '.$data->id , 201);
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
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response('API Target ikke fundet', 404);
        }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_edit')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response('API Target ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        return response('API Target opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_delete')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response('API Target ikke fundet', 404);
        }

        $data->delete();

        return response('API Target slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_delete_force')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Target ikke fundet', 404);
        }

        $data->forceDelete();

        return response('API Target permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'targets_restore')))
        {
            return response('Du har ikke de fornødne tilladelser', 403);
        }

        $data = Apitarget::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Target ikke fundet', 404);
        }

        $data->restore();

        return response('API Target genoprettet', 200);
    }

}
