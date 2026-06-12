<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProxyRequest;
use App\Models\Proxy;
use Illuminate\Http\Response;

class ProxyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Response(Proxy::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProxyRequest $request
     * @return Response
     */
    public function store(ProxyRequest $request)
    {
        $proxy = Proxy::create($request->all());
        return Response($proxy ? $proxy->toArray() : "proxy not stored", $proxy ? 200 : 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProxyRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ProxyRequest $request, int $id)
    {
        if ($proxy = Proxy::find($id)){
            $res = $proxy->update($request->all());
            return Response($res ? $proxy->toArray() : "proxy:$id not updated", $res ? 200 : 500);
        }
        return Response("proxy:$id not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        if ($proxy = Proxy::find($id)){
            $proxy = $proxy->delete();
            return Response('delete', $proxy ? 200 : 500);
        }
        return Response("proxy:$id not found", 404);
    }
}
