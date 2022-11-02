<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Models\Apitarget;
use App\Models\Apitoken;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * * @OA\get(
 *      path="/zones",
 *      summary="Get a list of Zones",
 *      description="Get a list of Zones",
 *      operationId="ZonesList",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of Zones"
 *   ),
 * )
 *
 * * @OA\get(
 *      path="/zones/deleted",
 *      summary="Get a list of deleted Zones",
 *      description="Get a list of deleted Zones",
 *      operationId="ZonesListDeleted",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *
 *   @OA\Response(
 *      response=200,
 *      description="List of deleted Zones"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/zones",
 *      summary="Create an Zone",
 *      description="Create a Zone",
 *      operationId="ZonesCreate",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="name",
 *              description="Name of the Zone",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Zone Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Zone created"
 *   ),
 * )
 *
 * @OA\get(
 *      path="/zones/{id}",
 *      summary="Get a specific Zone",
 *      description="Get a specific Zone",
 *      operationId="ZonesShow",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
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
 *      description="Zone object"
 *   ),
 * )
 *
 * @OA\post(
 *      path="/zones/{id}/notify",
 *      summary="Email all 'Lager Chefer' with an error message",
 *      description="Email all 'Lager Chefer' with an error message",
 *      operationId="ZonesNotify",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
 *              @OA\Schema(
 *                 type="integer",
 *                 example=1,
 *                  minimum=1
 *              ),
 *              in="path",
 *              required=true
 *      ),
 *      @OA\Parameter(
 *              name="type",
 *              description="Type af Notifikation",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Motion",
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *      @OA\Parameter(
 *              name="message",
 *              description="Optional Message",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Motion",
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *      @OA\Parameter(
 *              name="temperature",
 *              description="Temperature",
 *              @OA\Schema(
 *                 type="number",
 *                 example="2.2",
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *      @OA\Parameter(
 *              name="humidity",
 *              description="Humidity",
 *              @OA\Schema(
 *                 type="number",
 *                 example="50",
 *              ),
 *              in="query",
 *              required=false
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Lager Chefer Notified"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/zones/{id}",
 *      summary="Update an Zone",
 *      description="Update an Zone",
 *      operationId="ZonesUpdate",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
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
 *              name="name",
 *              description="Name of the Zone",
 *              @OA\Schema(
 *                 type="string",
 *                 example="Zone Name"
 *              ),
 *              in="query",
 *              required=true
 *      ),

 *   @OA\Response(
 *      response=200,
 *      description="Zone updated"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/zones/{id}",
 *      summary="Delete a Zone",
 *      description="Delete a Zone",
 *      operationId="ZonesDelete",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
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
 *      description="Zone deleted"
 *   ),
 * )
 *
 * @OA\delete(
 *      path="/zones/{id}/force",
 *      summary="Permanently Delete a Zone",
 *      description="Permanently Delete a Zone",
 *      operationId="ZonesDeleteForce",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
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
 *      description="Zone permanently deleted"
 *   ),
 * )
 *
 * @OA\put(
 *      path="/zones/{id}/restore",
 *      summary="Restore a deleted Zone",
 *      description="Restore a deleted Zone",
 *      operationId="ZonesRestore",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
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
 *      description="Zone restored"
 *   ),
 * )
 *
 *
 * @OA\put(
 *      path="/zones/{id}/types",
 *      summary="Update Types for Zone",
 *      description="Update Types for Zone",
 *      operationId="ZonesTypes",
 *      tags={"Zones"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *              name="id",
 *              description="ID of the Zone",
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
 *              name="types[]",
 *              description="Array of Type IDs",
 *              @OA\Schema(
 *                 type="array",
 *                  @OA\Items(type="integer"),
 *              ),
 *              in="query",
 *              required=true
 *      ),
 *
 *   @OA\Response(
 *      response=200,
 *      description="Zone restored"
 *   ),
 * )
 *
 * @OA\Post(
 *      path="/authenticate/zone",
 *      summary="Get API Key for Zone-controller by authenticating with a valid user",
 *      description="Get API Key for Zone-controller by authenticating with a valid user",
 *      operationId="AuthenticateZone",
 *      tags={"Authentication"},
 *      security={{"bearerAuth":{}}},
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
 *      description="API Token and User sent"
 *   ),
 *  @OA\Response(
 *      response=404,
 *      description="User not found"
 *   )
 * )
 */

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_viewAny')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Zoner'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_viewAny_deleted')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response()->json(['besked' => 'Ingen Slettede Zoner'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_create')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = (new Zone());

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'Zone oprettet med id: '.$data->id],201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_view')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::where('id','=',$id)
            ->first();

        if(!$data){
            return response()->json(['besked' => 'Zone ikke fundet'], 404);
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
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone ikke fundet'], 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();

        response()->json(['besked' => 'Zone opdateret'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_delete')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone ikke fundet'], 404);
        }

        $data->delete();

        response()->json(['besked' => 'Zone slettet'], 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function delete_force(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_delete_force')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone ikke fundet'], 404);
        }

        $data->forceDelete();

        response()->json(['besked' => 'Zone permanent slettet'],204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function restore(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_restore')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone ikke fundet'], 404);
        }

        $data->restore();

        response()->json(['besked' => 'Zone genoprettet'], 200);
    }

    /**
     * Update Types
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function types(Request $request, $id)
    {
        $token = Apitoken::where('token','=',$request->bearerToken())->first();
        if(!$token->role->permissions->contains(Permission::firstWhere('name', '=', 'zones_edit')))
        {
            return response()->json(['besked' => 'Du har ikke de fornødne tilladelser'], 403);
        }

        $data = Zone::where('id','=',$id)->first();
        if(!$data){
            return response()->json(['besked' => 'Zone ikke fundet'], 404);
        }

        $types = $request->types;
        $data->types()->sync($types);

        response()->json(['besked' => 'Typer opdateret'], 200);
    }

    /**
     * Authenticate the user.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password =  hash('sha512',$request->password);

        $user = User::where('email',"=",$email)
            ->where('password',"=",$password)
            ->first()
        ;

        if(!$user){
            return response()->json(['besked' => 'Bruger ikke fundet'],404);
        }

        $token = Apitoken::where('target_id',"=",Apitarget::where('name','=',"Zone-Controller")->first()->id)->first();

        return $token;
    }

    /**
     * Notify the user.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function notify(Request $request, $id)
    {
        $zone = Zone::where('id','=',$id)->first();
        $type = $request->type;
        $temperature = $request->temperature ?? Null;
        $humidity = $request->humidity ?? Null;
        $my_message = $request->message ?? Null;

        $recipients = collect();
        $storage_boss = Role::where('name','=','Lager Chef')->first();
        foreach($storage_boss->users as $user){
            $recipients->push($user->email);
        }
        if($type == "motion"){
            $recipients->push("bedste@vagt.dk");
        }

        $input_data = collect();
        $input_data->put('type', $type);
        $input_data->put('temperature', $temperature);
        $input_data->put('humidity', $humidity);
        $input_data->put('message', $my_message);

        $data = collect();
        $data->put('message','Emails sendt til modtagere');
        $data->put('modtagere',$recipients);
        $data->put('data',$input_data);

        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new NotificationMail($zone,$type,$temperature,$humidity,$my_message));
        }

        return response()->json($data,200);
    }

    /**
     * Notify the user.
     *
     * @return NotificationMail
     */
    public function notify_view(Request $request, $id, $type = Null,$temperature = Null,$humidity = Null, $my_message = Null)
    {
        $zone = Zone::where('id','=',$id)->first();
        $type = $type ?? Null;
        $temperature = $temperature ?? Null;
        $humidity = $humidity ?? Null;
        $my_message = $my_message ?? Null;

        return new NotificationMail($zone,$type,$temperature,$humidity,$my_message);
    }

}
