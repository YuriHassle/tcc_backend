<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use Illuminate\Database\Eloquent\Builder;

class BookingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bookings = Booking::query();
        
        if ($request->filled('inn_id')) {
            $bookings->whereHas('package', function (Builder $query) use ($request){
                $query->where('inn_id', $request->inn_id);
            });
        }

        $bookings = $bookings->orderBy('checkin')->get();

        return $this->sendResponse(BookingResource::collection($bookings), 'Reservas recuperadas com sucesso');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        if ($request->validated()) {
            $booking = $request->all();
            $booking = Booking::create($booking);
            return $this->sendResponse(new BookingResource($booking), 'Reserva criada com sucesso', 201);
        } else {
            return $this->sendError('Erro na validação dos dados.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        if (!$request->validated()) {
            return $this->sendError('Erro na validação dos dados');
        }

        $booking->update($request->all());
        return $this->sendResponse(new BookingResource($booking), 'Reserva atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return $this->sendResponse($booking, 'Reserva excluída com sucesso');
    }
}
