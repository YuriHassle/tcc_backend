<?php

namespace App\Http\Controllers;

use App\Models\Inn;
use App\Models\Address;
use App\Http\Requests\StoreInnRequest;
use App\Http\Requests\UpdateInnRequest;
use App\Http\Resources\InnResource;
use Illuminate\Support\Facades\Auth;

class InnController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $inns = Inn::all()->where('user_id', $user->id);

        return $this->sendResponse(InnResource::collection($inns), 'Pousadas recuperadas com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInnRequest $request)
    {
        if (!$request->validated()) {
            return $this->sendError('Erro na validação dos dados');
        }

        $user = Auth::user();
        $address = $request->only(['address'])['address'];
        $inn = $request->except(['address']);
        
        $address = Address::create($address);
        if(is_null($address)){
            return $this->sendError('Não foi possível cadastrar o endereço.');
        } 

        $inn['address_id'] = $address->id;
        $inn['user_id'] = $user->id;
        $inn = Inn::create($inn);

        return $this->sendResponse(new InnResource($inn), 'Pousada cadastrada com sucesso.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inn  $inn
     * @return \Illuminate\Http\Response
     */
    public function show(Inn $inn)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInnRequest  $request
     * @param  \App\Models\Inn  $inn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInnRequest $request, Inn $inn)
    {
        if (!$request->validated()) {
            return $this->sendError('Erro na validação dos dados');
        }

        $addressPayload = $request->only(['address'])['address'];
        $innPayload = $request->except(['address']);

        $address = Address::find($inn->address_id);
        $address->update($addressPayload);
        $inn->update($innPayload);
        return $this->sendResponse(new InnResource($inn), 'Pousada atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inn  $inn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inn $inn)
    {
        $inn->delete();
        return $this->sendResponse($inn, 'Pousada excluída com sucesso');
    }
}
