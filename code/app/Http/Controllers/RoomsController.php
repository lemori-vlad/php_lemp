<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomTimeSlot;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

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

    public function reserveSlot(request $request, int $roomId): JsonResponse
    {
        try {
            $room = Room::findOrFail($roomId);
            $validated = Validator::make($request->all(), [
                'timeslot_id' => 'required|integer',
                // must be received from auth (jwt token etc.)
                'reserved_by_id' => 'required|integer',
            ])->validate();

            $timeSlot = RoomTimeSlot::find($validated['timeslot_id']);

            if (!$timeSlot) {
                return response()->json([
                    'message' => 'Requested time slot not found'
                ], 404);
            }

            if ($timeSlot->is_reserved) {
                return response()->json([
                    'message' => 'This timeslot is already reserved'
                ], 409);
            }

            // create the reservation
            $timeSlot->is_reserved = true;
            $timeSlot->reserved_by_id = $validated['reserved_by_id'];
            $timeSlot->saveOrFail();

            return response()->json([
                'slot' => $timeSlot->refresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                   'message' => 'Requested room not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->validator->messages()->first()
            ], 422);
        } catch (Throwable $e) {
            Log::error("Can't create a reservation", [
                'exception' => $e->getMessage(),
                // 'stacktrace' => $e->getTrace()
            ]);

            return response()->json([
                'message' => 'Internal error'
            ], 500);
        }

    }
}
