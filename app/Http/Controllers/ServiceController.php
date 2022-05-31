<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::query();
        
        if ($request->filled('inn_id')) {
            $services->where('inn_id', $request->inn_id);
        }

        $services = $services->orderBy('name')->get();

        return $this->sendResponse(ServiceResource::collection($services), 'Serviços recuperados com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        if ($request->validated()) {
            $service = Service::create($request->all());
            return $this->sendResponse(new ServiceResource($service), 'Serviço criado com sucesso', 201);
        } else {
            return $this->sendError('Erro na validação dos dados.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        if (!$request->validated()) {
            return $this->sendError('Erro na validação dos dados');
        }

        $service->update($request->all());
        return $this->sendResponse(new ServiceResource($service), 'Serviço atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return $this->sendResponse($service, 'Serviço excluído com sucesso');
    }
}
