<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        foreach ($items as &$value) {
            if (is_resource($value['data'])) {
                unset($value['data']); // BLOB
            }
        }
        return response()->json(['items' => $items]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $item = Item::find($id);
        if (is_resource($value['data'])) {
            unset($item['data']);
        }
        return response()->json($item);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
