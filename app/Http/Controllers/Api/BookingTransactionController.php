<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class BookingTransactionController extends Controller
{
    public function booking_details(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'booking_trx_id' => 'required|string',
        ]);

        $booking = BookingTransaction::where('phone_number', $request->phone_number)
            ->where('booking_trx_id', $request->booking_trx_id)
            ->with(['officeSpace', 'officeSpace.city'])
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        } else {
            return new ViewBookingResource($booking);
        }
    }

    public function store(StoreBookingTransactionRequest $request)
    {
        $validatedData = $request->validated();

        $officeSpace = OfficeSpace::findOrFail($validatedData['office_space_id']);

        $validatedData['is_paid'] = false;
        $validatedData['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();
        $validatedData['duration'] = $officeSpace->duration;
        $validatedData['ended_at'] = (new \DateTime($validatedData['started_at']))
            ->modify("+{$officeSpace->duration} days");

        $bookingTransaction = BookingTransaction::create($validatedData);

        $phone = $bookingTransaction->phone_number;

        if (str_starts_with($phone, '08')) {
            $phone = '62' . substr($phone, 1);
        }


       try {
        $messageBody  = "Hi {$bookingTransaction->name}, Terima kasih telah booking kantor di FirstOffice.\n\n";
        $messageBody .= "Pesanan kantor {$bookingTransaction->officeSpace->name} sedang kami proses.\n";
        $messageBody .= "Booking TRX ID: {$bookingTransaction->booking_trx_id}\n\n";
        $messageBody .= "Kami akan menginformasikan status pemesanan Anda secepat mungkin.";

        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target'  => $phone,
            'message' => $messageBody,
        ]);

        if (!$response->successful()) {
            Log::error('Fonnte Error', [
                'response' => $response->body(),
            ]);
        }

    } catch (\Exception $e) {
        Log::error('Fonnte Exception: ' . $e->getMessage());
    }

    $bookingTransaction->load('officeSpace');

    return new BookingTransactionResource($bookingTransaction);
 }
}