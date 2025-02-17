<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;


class ProfileController extends Controller
{
    public function edit()
    {
        $user =auth()->user();  
        $profile = $user->profile;

        return view('profile.edit', compact('user', 'profile'));
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $activeTab = $request->query('tab', 'listed');

        if (!$profile) {
            return redirect()->route('profile.edit');
        }

        $listedItems = Item::where('user_id', $user->id)
            ->latest()
            ->get();

        $purchasedItems = Purchase::where('user_id', $user->id)
            ->with('item')
            ->latest()
            ->get()
            ->map(function ($purchase)
            {
                return $purchase->item;
            });

        return view('profile.profile', compact(
            'user',
            'profile',
            'listedItems',
            'purchasedItems',
            'activeTab'
        ));
    }

    public function update(AddressRequest $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image) {
              
                Storage::delete($profile->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
        }

       
        $profile->user_id = $user->id;
        $profile->postal_code = $request->postal_code;
        $profile->address = $request->address;
        $profile->building_name = $request->building_name;

        $profile->save();
        $user->name = $request->name;
        $user->save();

          return redirect()->route('profile.profile');  
    }
}
