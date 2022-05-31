<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Resources\PackageResource;

class PackageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $packages = Package::query();
        
        if ($request->filled('inn_id')) {
            $packages->where('inn_id', $request->inn_id);
        }

        $packages = $packages->orderBy('name')->get();

        return $this->sendResponse(PackageResource::collection($packages), 'Pacotes recuperados com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
    {
        if ($request->validated()) {
            $package = Package::create($request->all());
            return $this->sendResponse(new PackageResource($package), 'Pacote criado com sucesso', 201);
        } else {
            return $this->sendError('Erro na validação dos dados.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackageRequest  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        if (!$request->validated()) {
            return $this->sendError('Erro na validação dos dados');
        }

        $package->update($request->all());
        return $this->sendResponse(new PackageResource($package), 'Pacote atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return $this->sendResponse($package, 'Pacote excluído com sucesso');
    }
}
