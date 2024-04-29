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
                'descr' => 'nullable|string|max:255',
                'soften' => 'boolean',
                'limit' => 'integer|max:100',
            ]);
        } catch (\Throwable $e) {
            return error($e->getMessage());
        }

        $descr = $query['descr'] ?? '';
        $soften = $query['soften'] ?? false;
        $limit = $query['limit'] ?? 100;

        $estate = Estate::where('descr', 'like', '%'.$descr.'%');

        if ($soften) $estate->orderBy(Estate::raw("
            CASE
                WHEN descr = '{$descr}' THEN 1
                WHEN descr LIKE '{$descr}%' THEN 2
                ELSE 3
            END
        ", [':value' => $descr]), 'asc');

        if (!$descr) $estate->orderByRaw('rand()');

        $found = $estate->limit($limit)->get();

        return json(['Estates' => $found]);
    }
}
