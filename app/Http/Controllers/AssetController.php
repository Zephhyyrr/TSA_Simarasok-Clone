<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;

class AssetController extends Controller
{
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        if (file_exists(public_path('media/' . $asset->nama))) {
            unlink(public_path('media/' . $asset->nama));
        }
        $asset->delete();

        return response()->json(['success' => true]);
    }
}
