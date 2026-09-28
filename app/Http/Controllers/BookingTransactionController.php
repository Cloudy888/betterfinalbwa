<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Services\BookingTransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    private BookingTransactionService $bookingTransactionService;

    public function __construct(BookingTransactionService $bookingTransactionService)
    {
       $this->bookingTransactionService = $bookingTransactionService;
    }

    public function index()
    {
        $transactions = $this->bookingTransactionService->getAll();
        return response()->json(TransactionResource::collection($transactions));
    }

    public function show(int $id)
    {
        try {
            $transactions = $this->bookingTransactionService->getByIdForManager($id);
            return response()->json(new TransactionResource($transactions));
        } catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        try{
            $transactions = $this->bookingTransactionService->updateStatus($id, $validated['status']);
            return response()->json([
                'message' => 'Transaction status updated successfully.',
                'data' => new TransactionResource($transactions),
            ]);
        } catch (ModelNotFoundException $e){
            return response()->json(['message'=>'Transaction not found'], 404);
        }
    }
}
