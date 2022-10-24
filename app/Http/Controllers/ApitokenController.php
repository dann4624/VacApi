<?php

namespace App\Http\Controllers;

use App\Models\Apitoken;
use Illuminate\Http\Request;

class ApitokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Apitoken::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen API Tokens', 404);
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
        $data = Apitoken::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede API Tokens', 404);
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
        $data = (new Apitoken());
        $timestamp = now();
        $data->token = hash('sha512',$timestamp);
        $data->target_id = $request->target_id;
        $data->role_id = $request->role_id;
        $data->expires_at = $request->expires_at;
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
        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
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
        $data = Apitoken::where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }
        $data->target_id = $request->target_id;
        $data->role_id = $request->role_id;
        $data->expire_at = $request->expires_at;
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
        $data = Apitoken::where('id','=',$id)->first();
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
        $data = Apitoken::onlyTrashed()->where('id','=',$id)->first();
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
        $data = Apitoken::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('API Token ikke fundet', 404);
        }
        $data->restore();
        return response('API Token genoprettet', 204);
    }
}
