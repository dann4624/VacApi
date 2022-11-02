<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * /**
 * @OA\get(
 *      path="/users",
 *      summary="Get a list of Users",
 *      description="Get a list of Users",
 *      operationId="UsersList",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Users"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/users/deleted",
 *      summary="Get a list of deleted Users",
 *      description="Get a list of deleted Users",
 *      operationId="UsersListDeleted",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Users"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/users",
 *      summary="Create an User",
 *      description="Create an User",
 *      operationId="UsersCreate",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the User",
 *              @OA\Schema(
 *                 type="string",
 *                 example="User Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="email",
 *              description="Email",
 *              @OA\Schema(
 *                 type="string",
 *                 format="email",
 *                 minimum=5,
 *                 example="dann4624@edu.sde.dk"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *     @OA\Parameter(
 *              name="password",
 *              description="Password",
 *              @OA\Schema(
 *                 type="string",
 *                 format="password",
 *                 minimum=5,
 *                 example="Pass.1234"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *     @OA\Parameter(
 *              name="role_id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="User created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/users/{id}",
 *      summary="Get a specific User",
 *      description="Get a specific User",
 *      operationId="UsersShow",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User",
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
 *      description="User object"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/users/{id}",
 *      summary="Update an User",
 *      description="Update an User",
 *      operationId="UsersUpdate",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User",
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
 *              description="Name of the User",
 *              @OA\Schema(
 *                 type="string",
 *                 example="User Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *      @OA\Parameter(
 *              name="email",
 *              description="Email",
 *              @OA\Schema(
 *                 type="string",
 *                 format="email",
 *                 minimum=5,
 *                 example="dann4624@edu.sde.dk"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *     @OA\Parameter(
 *              name="password",
 *              description="Password",
 *              @OA\Schema(
 *                 type="string",
 *                 format="password",
 *                 minimum=5,
 *                 example="Pass.1234"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *     @OA\Parameter(
 *              name="role_id",
 *              description="ID of the Role",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="query",
 *              required=true
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="User updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/users/{id}",
 *      summary="Delete an User",
 *      description="Delete an User",
 *      operationId="UsersDelete",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User",
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
 *      description="User deleted"
 *   ),
 * )
 *
 *
 * @OA\delete(
 *      path="/users/{id}/force",
 *      summary="Permanently delete an User",
 *      description="Permanently delete an User",
 *      operationId="UsersDeleteForce",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User",
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
 *      description="User permanently deleted"
 *   ),
 * )
 *
 * *
 * @OA\put(
 *      path="/users/{id}/restore",
 *      summary="Restore a deleted User",
 *      description="Restore a deleted User",
 *      operationId="UsersRestore",
 *      tags={"Users"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the User",
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
 *      description="User restored"
 *   ),
 * )
 *
 * @OA\Post(
 *      path="/authenticate/app",
 *      summary="Get API Key for App by authenticating with a valid user",
 *      description="Get API Key for App by authenticating with a valid user",
 *      operationId="AuthenticateApp",
 *      tags={"Authentication"},
 *      @OA\Parameter(
 *              name="email",
 *              description="email",
 *              @OA\Schema(
 *                 type="string",
 *                 format="email",
 *                 minimum=5,
 *                 example="dann4624@edu.sde.dk"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="password",
 *              description="password",
 *              @OA\Schema(
 *                 type="string",
 *                 format="password",
 *                 minimum=5,
 *                 example="Pass.1234"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *   @OA\Response(
 *      response=200,
 *      description="API Token Opdateret"
 *   ),
 *  @OA\Response(
 *      response=404,
 *      description="Bruger ikke fundet"
 *   )
 * )
 *
 * @OA\Post(
 *      path="/authenticate/panel",
 *      summary="Get API Key for Admin Panel by authenticating with a valid user",
 *      description="Get API Key for Admin Panel by authenticating with a valid user",
 *      operationId="AuthenticatePanel",
 *      tags={"Authentication"},
 *      @OA\Parameter(
 *              name="email",
 *              description="Email",
 *              @OA\Schema(
 *                 type="string",
 *                 format="email",
 *                 minimum=5,
 *                 example="dann4624@edu.sde.dk"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="password",
 *              description="Password",
 *              @OA\Schema(
 *                 type="string",
 *                 format="password",
 *                 minimum=5,
 *                 example="Pass.1234"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *   @OA\Response(
 *      response=200,
 *      description="User Authenticated"
 *   ),
 *  @OA\Response(
 *      response=404,
 *      description="User Not Found"
 *   )
 * )
 */

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Brugere'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Brugere'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new User());


        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->email)){
            $data->email = $request->email;
        }

        if(isset($request->password)){
            $data->password = hash('sha512',$request->password);
        }

        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }


        $data->save();

        response()->json(['besked' => 'Bruger oprettet med id: '.$data->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        if(isset($request->email)){
            $data->email = $request->email;
        }

        if(isset($request->password)){
            $data->password = hash('sha512',$request->password);
        }

        if(isset($request->role_id)){
            $data->role_id = $request->role_id;
        }

        $data->save();

        response()->json(['besked' => 'Bruger opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Bruger slettet'],204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Bruger permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'users_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = User::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Bruger genoprettet'], 200);
    }

    /**
     * Authenticate the user from the App.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function authenticate_app(Request $request)
    {
        $email = $request->email;
        $password =  hash('sha512',$request->password);

        $user = User::where('email',"=",$email)
            ->where('password',"=",$password)
            ->first()
        ;

        if(!$user){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
        }

        $token = Apitoken::where('target_id','=',Apitarget::where('name','=',"App")->first()->id)
            ->where('role_id','=',$user->role->id)
            ->first()
        ;

        $data = collect();
        $data->add($user);
        $data->add($token);

        return response()->json($data,200);
    }

    /**
     * Authenticate the user from the Admin Panel.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function authenticate_panel(Request $request)
    {
        $email = $request->email;
        $password =  hash('sha512',$request->password);

        $user = User::where('email',"=",$email)
            ->where('password',"=",$password)
            ->first()
        ;

        if(!$user){
            return response()->json(['besked' => 'Bruger ikke fundet'], 404);
        }

        $token = Apitoken::where('target_id','=',Apitarget::where('name','=',"Admin-Panel")->first()->id)
            ->where('role_id','=',$user->role->id)
            ->first()
            ->load('role')
            ->load('target')
        ;

        $data = collect();
        $data->add($user);
        $data->add($token);

        return response()->json($data,200);
    }
}
