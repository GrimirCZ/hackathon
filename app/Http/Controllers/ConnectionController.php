<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConnectionDetailResource;
use App\Http\Resources\ConnectionResource;
use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //

        return ConnectionResource::collection(
            Connection::join("snapshots", "snapshots.connection_id", "=", "connections.id")
                ->where('is_old', false)
                ->select("connections.*")
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return ConnectionDetailResource
     */
    public function show($id)
    {
        //
        return new ConnectionDetailResource(Connection::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
