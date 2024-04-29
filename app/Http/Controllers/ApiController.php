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
                'name' => 'string|max:255',
                'soften' => 'boolean',
                'limit' => 'integer|max:100',
            ]);
        } catch (\Throwable $e) {
            return error($e->getMessage());
        }

        $name = $query['name'] ?? '';
        $soften = $query['soften'] ?? false;
        $limit = $query['limit'] ?? 100;

        if ($soften) $user = Estate::where('name', 'like', '%'.$name.'%')->orderBy(Estate::raw('
            IF(name = ":value", 1, 0) AND
            IF(name LIKE ":value%", 1, 0) AND
            IF(name LIKE "%:value%", 1, 0) AND
            name
        ', [':value' => $name]), 'asc');
        else $user = Estate::where('name', $name);

        $user->limit($limit);

        $found = $user->get();

        return json(['Estates' => $found->toArray()]);
    }
}
