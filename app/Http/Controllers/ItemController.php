<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;


class ItemController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Item::query();
        
        if ($request->filled('inn_id')) {
            $items->where('inn_id', $request->inn_id);
        }

        $items = $items->orderBy('name')->get();

        return $this->sendResponse(ItemResource::collection($items), 'Itens recuperados com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        if ($request->validated()) {
            $item = Item::create($request->all());
            return $this->sendResponse(new ItemResource($item), 'Item criado com sucesso', 201);
        } else {
            return $this->sendError('Erro na validação dos dados.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        if (!$request->validated()) {
            return $this->sendError('Erro na validação dos dados');
        }

        $item->update($request->all());
        return $this->sendResponse(new ItemResource($item), 'Item atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return $this->sendResponse($item, 'Item excluído com sucesso');
    }
}
