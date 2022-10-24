<?php

namespace App\Http\Controllers;

use App\Models\Apitarget;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Apitarget::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen API Targets', 404);
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function deleted()
    {
        $data = Apitarget::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede API Targets', 404);
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = (new Apitarget());
        $data->name = $request->name;
        $data->save();

        return response('API Token oprettet med id: '.$data->id , 202);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response('API Target ikke fundet', 404);
        }

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }
        $data->name = $request->name;
        $data->save();
        return response('API Token opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Apitarget::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }
        $data->delete();
        return response('API Token slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force($id)
    {
        $data = Apitarget::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }
        $data->forceDelete();
        return response('API Token permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $data = Apitarget::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }
        $data->restore();
        return response('API Token genoprettet', 204);
    }

}
