<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('subitems')->get();

        // BLOB型を除外する
        foreach ($items as &$value) {
            if (is_resource($value['data'])) {
                unset($value['data']);
            }
        }

        return response()->json(['items' => $items]);
    }

    public function store(Request $request)
    {
        $item = new Item;
        $subitem->fill($request->all());
        $item->save();
        return response(null, 201);
    }

    public function show($id)
    {
        $item = Item::with('subitems')->find($id);
        if ($item->exists()) {
            // BLOB型を除外する
            if (is_resource($item['data'])) {
                unset($item['data']);
            }
            return response()->json($item);
        } else {
            return response(null, 404);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item->exists()) {
            $item = new Item;
        }

        // PUTまたはPATCH
        // →PATCHの場合は部分更新
        if ($request->isMethod('put')) {
            $item->fill($request->all());
        } elseif ($request->isMethod('patch')) {
            if (strlen($request->title) > 0) {
                $item->title = $request->title;
            }
            if (strlen($request->content) > 0) {
                $item->content = $request->content;
            }
            if (strlen($request->data) > 0) {
                $item->data = $request->data;
            }
            if (strlen($request->confirmed) > 0) {
                $item->confirmed = $request->confirmed;
            }
            if (strlen($request->amount) > 0) {
                $item->amount = $request->amount;
            }
            if (strlen($request->visitor) > 0) {
                $item->visitor = $request->visitor;
            }
            if (strlen($request->options) > 0) {
                $item->options = $request->options;
            }
            if (strlen($request->description) > 0) {
                $item->description = $request->description;
            }
            if (strlen($request->device) > 0) {
                $item->device = $request->device;
            }
            if (strlen($request->guid) > 0) {
                $item->guid = $request->guid;
            }
        }

        $item->save();
        return response(null, 204);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if ($item->exists()) {
            $item->delete();
            return response(null, 204);
        } else {
            return response(null, 404);
        }
    }
}
