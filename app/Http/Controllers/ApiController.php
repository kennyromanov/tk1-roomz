<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Estate;

function error($message): JsonResponse
{
    return response()->json([
        'success' => 0,
        'error' => $message,
    ]);
}
function json($data): JsonResponse
{
    return response()->json([
        'success' => 1,
        'data' => $data,
    ]);
}

class ApiController extends Controller
{
    public function getEstates(Request $request): JsonResponse
    {
        try {
            $query = $request->validate([
                'search' => 'nullable|string|max:255',
                'soften' => 'nullable|boolean',
                'picture' => 'nullable|boolean',
                'minRooms' => 'nullable|integer|min:0',
                'maxRooms' => 'nullable|integer|min:1',
                'minArea' => 'nullable|integer|min:0',
                'maxArea' => 'nullable|integer|min:1',
                'limit' => 'nullable|integer|max:100',
            ]);
        } catch (\Throwable $e) {
            return error($e->getMessage());
        }

        $search = $query['search'] ?? '';
        $soften = $query['soften'] ?? 0;
        $picture = $query['picture'] ?? 0;
        $minRooms = $query['minRooms'] ?? null;
        $maxRooms = $query['maxRooms'] ?? null;
        $minArea = $query['minArea'] ?? null;
        $maxArea = $query['maxArea'] ?? null;
        $limit = $query['limit'] ?? 100;

        $estate = Estate::where('descr', 'like', '%'.$search.'%');

        if (isset($minRooms)) $estate->whereRaw("num_rooms_bedrooms + num_rooms_livingrooms >= {$minRooms}");
        if (isset($maxRooms)) $estate->whereRaw("num_rooms_bedrooms + num_rooms_livingrooms <= {$maxRooms}");
        if (isset($minArea)) $estate->where('num_area', '>=', $minArea);
        if (isset($maxArea)) $estate->where('num_area', '<=', $maxArea);
        if ($picture) $estate->whereRaw("picture_filename is not null");

        if ($soften) $estate->orderBy(Estate::raw("
            CASE
                WHEN descr = '{$search}' THEN 1
                WHEN descr LIKE '{$search}%' THEN 2
                ELSE 3
            END
        ", [':value' => $search]), 'asc');

        if (!$search) $estate->orderBy('descr', 'asc');

        $found = $estate->limit($limit)->get();

        return json(['Estates' => $found]);
    }
}
