<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Item;

use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    public function index()
    {
        Log::debug('index()');

        $items = Item::with('subitems')->get();

        // BLOB型を除外する
        foreach ($items as &$value) {
            if (is_resource($value['data'])) {
                unset($value['data']);
            }
        }

        return response()->json(['items' => $items]);
    }

    public function store(ItemRequest $request)
    {
        Log::debug(sprintf('store(%s)', $request));

        $item = new Item;
        $subitem->fill($request->all());
        $item->save();
        return response(null, 201);
    }

    public function show($id)
    {
        Log::debug(sprintf('show(%s)', $id));

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

    public function update(ItemRequest $request, $id)
    {
        Log::debug(sprintf('update(%s, %s)', $request, $id));

        $item = Item::find($id);
        if (!$item->exists()) {
            $item = new Item;
        }

        // PUTまたはPATCH
        // →PATCHの場合は部分更新
        if ($request->isMethod('put')) {
            $item->fill($request->all());
        } elseif ($request->isMethod('patch')) {
            foreach ($item->get_fillable() as $value) {
                if (strlen($request->$value) > 0) {
                    $item->$value = $request->$value;
                }
            }
        }

        $item->save();
        return response(null, 204);
    }

    public function destroy($id)
    {
        Log::debug(sprintf('destroy(%s)', $id));

        $item = Item::find($id);
        if ($item->exists()) {
            $item->delete();
            return response(null, 204);
        } else {
            return response(null, 404);
        }
    }
}
