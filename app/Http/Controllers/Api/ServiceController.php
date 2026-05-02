<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        return response()->json($query->get(), 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Послугу не знайдено'
            ], 404, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json($service, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id'
        ]);

        $service = Service::create($validated);

        return response()->json($service, 201, [], JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Послугу не знайдено'
            ], 404, [], JSON_UNESCAPED_UNICODE);
        }

        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id'
        ]);

        $service->update($validated);

        return response()->json($service, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Deleted'], 200, [], JSON_UNESCAPED_UNICODE);
    }
}