<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingTransactionResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    //

    public function store(StoreBookingRequest $request)
    {
        $validatedData = $request->validated();

        $officeSpace = OfficeSpace::find($validatedData['office_space_id']);

        $validatedData['is_paid'] = false;
        $validatedData['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();
        $validatedData['duration'] = $officeSpace->duration;

        $validatedData['ended_at'] = (new \DateTime("{$validatedData['started_at']}"))->modify("+{$officeSpace->duration} days")->format('Y-m-d');

        $bookingTransaction = BookingTransaction::create($validatedData);

        $bookingTransaction->load('officeSpace');
        return new BookingTransactionResource($bookingTransaction);
    }
}
