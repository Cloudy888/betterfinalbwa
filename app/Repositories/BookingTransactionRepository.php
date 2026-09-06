<?php

namespace App\Repositories;

use App\Models\BookingTransaction;

class BookingTransactionRepository
{

    //manager queries
    public function getAll()
    {
        return BookingTransaction::with(['doctor', 'doctor.hospital', 'doctor.specialists','user'])
        ->latest()
        ->paginate(10);
    }

    public function getByIdForManager(int $id)
    {
        return BookingTransaction::with(['doctor', 'doctor.hospital', 'doctor.specialists', 'user'])
            ->findOrFail($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $transaction = $this->getByIdForManager($id);
        $transaction->update(['status'=> $status]);
        return $transaction;
    }



    //costumer queries
    public function getAllforuser(int $userId)
    {
        return BookingTransaction::where('user_id', $userId)
        ->with(['doctor', 'doctor.hospital', 'doctor.specialists'])
        ->latest()
        ->paginate(10);
    }

    public function getById(int $id, int $userId)
    {
        return BookingTransaction::where('id', $id)
            ->where('user_id', $userId)
            ->with(['doctor', 'doctor.hospital', 'doctor.specialists'])
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return BookingTransaction::create($data);
    }

    public function isTimeSlotTakenForDoctor(int $doctorId, string $date, string $time): bool
    {
        return BookingTransaction::where('doctor_id', $doctorId)
            ->where('started_at', $date)
            ->where('time', $time)
            ->exists();
    }
}