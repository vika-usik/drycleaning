<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $services = [
        ['id' => 1, 'name' => "Чистка куртки", 'category_id' => 1],
        ['id' => 2, 'name' => "Чистка пальта", 'category_id' => 1],
        ['id' => 3, 'name' => "Чистка костюма", 'category_id' => 1],
        ['id' => 4, 'name' => "Чистка сукні", 'category_id' => 2]
    ];

    public function index(Request $request)
    {
        $data = $this->services;

        if ($request->has('category_id')) {
            $data = array_filter($data, function ($service) use ($request) {
                return $service['category_id'] == $request->category_id;
            });
        }

        return response()->json(array_values($data));
    }

    public function show($id)
    {
        $service = collect($this->services)->firstWhere('id', $id);

        if (!$service) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($service);
    }
}