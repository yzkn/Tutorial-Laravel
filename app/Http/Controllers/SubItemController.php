<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\SubItem;

class SubItemController extends Controller
{
    public function index()
    {
        $subitems = SubItem::all();
        return response()->json(['subitems' => $subitems]);
    }

    public function store(Request $request)
    {
        $subitem = new SubItem;
        $subitem->fill($request->all());
        $subitem->save();
        return response(null, 201);
    }

    public function show($id)
    {
        $subitem = SubItem::find($id);
        if ($subitem->exists()) {
            return response()->json($subitem);
        } else {
            return response(null, 404);
        }
    }

    public function update(Request $request, $id)
    {
        $subitem = SubItem::find($id);
        if (!$subitem->exists()) {
            $subitem = new Item;
        }

        // PUTまたはPATCH
        // →PATCHの場合は部分更新
        if ($request->isMethod('put') || (strlen($request->subtitle) > 0)) {
            $subitem->subtitle = $request->subtitle;
        }
        if ($request->isMethod('put') || (strlen($request->subcontent) > 0)) {
            $subitem->subcontent = $request->subcontent;
        }

        $subitem->save();
        return response(null, 204);
    }

    public function destroy($id)
    {
        $subitem = SubItem::find($id);
        if ($subitem->exists()) {
            $subitem->delete();
            return response(null, 204);
        } else {
            return response(null, 404);
        }
    }
}
