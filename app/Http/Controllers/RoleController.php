<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Role::orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Roller', 404);
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
        $data = Role::onlyTrashed()->orderBy('id','ASC')->get();
        if(count($data) == 0){
            return response('Ingen Slettede Roller', 404);
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
        $data = (new Role());
        $data->name = $request->name;
        $data->save();

        return response('Rolle oprettet med id: '.$data->id , 202);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
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
        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }

        if(isset($request->name)){
            $data->name = $request->name;
        }

        $data->save();
        return response('Rolle opdateret', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Role::where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }
        $data->delete();
        return response('Rolle slettet', 204);
    }

    /**
     * Permanently Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_force($id)
    {
        $data = Role::onlyTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }
        $data->forceDelete();
        return response('Rolle permanent slettet', 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $data = Role::withTrashed()->where('id','=',$id)->first();
        if(!$data){
            return response('Rolle ikke fundet', 404);
        }
        $data->restore();
        return response('Rolle genoprettet', 204);
    }
}
