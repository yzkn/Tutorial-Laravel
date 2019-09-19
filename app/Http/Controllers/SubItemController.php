<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\SubItem;

use App\Http\Requests\SubItemRequest;

class SubItemController extends Controller
{
    public function index()
    {
        Log::debug('index()');

        $subitems = SubItem::all();
        return response()->json(['subitems' => $subitems]);
    }

    public function store(SubItemRequest $request)
    {
        Log::debug(sprintf('store(%s)', $request));

        $subitem = new SubItem;
        $subitem->fill($request->all());
        $subitem->save();
        return response(null, 201);
    }

    public function show($id)
    {
        Log::debug(sprintf('show(%s)', $id));

        $subitem = SubItem::find($id);
        if ($subitem->exists()) {
            return response()->json($subitem);
        } else {
            return response(null, 404);
        }
    }

    public function update(SubItemRequest $request, $id)
    {
        Log::debug(sprintf('update(%s, %s)', $request, $id));

        $subitem = SubItem::find($id);
        if (!$subitem->exists()) {
            $subitem = new Item;
        }

        // PUTまたはPATCH
        // →PATCHの場合は部分更新
        if ($request->isMethod('put')) {
            $subitem->fill($request->all());
        } elseif ($request->isMethod('patch')) {
            foreach ($subitem->get_fillable() as $value) {
                if (strlen($request->$value) > 0) {
                    $subitem->$value = $request->$value;
                }
            }
        }

        $subitem->save();
        return response(null, 204);
    }

    public function destroy($id)
    {
        Log::debug(sprintf('destroy(%s)', $id));

        $subitem = SubItem::find($id);
        if ($subitem->exists()) {
            $subitem->delete();
            return response(null, 204);
        } else {
            return response(null, 404);
        }
    }
}
