<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar_config'                 => 'required|array',
            'avatar_config.hair'            => 'required|in:short,long,curly,buzz,ponytail,bald',
            'avatar_config.hairColor'       => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'avatar_config.skin'            => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'avatar_config.outfit'          => 'required|in:hoodie,tshirt,shirt,sweater',
            'avatar_config.outfitColor'     => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'avatar_config.accessory'       => 'required|in:none,glasses,cap,earrings',
            'avatar_config.background'      => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $user->avatar_config = $request->input('avatar_config');
        $user->save();

        return response()->json([
            'success'       => true,
            'message'       => 'Avatar mis à jour !',
            'avatar_config' => $user->avatar_config,
        ]);
    }
}