<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomsController extends Controller
{
    public function getAvailableSlots(request $request, int $roomId): JsonResponse
    {
        $room = Room::find($roomId);

        if (!$room) {
            return response()->json([
                'message' => 'Requested room not found'
            ], 404);
        }

        $validator = Validator::make(
            [
                'reserved_by_id' => $request->input('reserved_by_id'),
                'is_reserved' => $request->input('is_reserved', NULL),
            ],
            [
                'reserved_by_id' => 'nullable|integer|exists:users,id',
                'is_reserved' => 'nullable|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first()
            ], 422);
        }

        $validated = $validator->validated();

        $query = $room->timeSlots();

        if (isset($validated['reserved_by_id'])) {
            $query = $query->where('reserved_by_id', $validated['reserved_by_id']);
        }

        if (isset($validated['is_reserved'])) {
            $query = $query->where('is_reserved', $validated['is_reserved']);
        }

        return response()->json([
            'room_id' => $roomId,
            'slots' => $query->get()
        ]);
    }
}
