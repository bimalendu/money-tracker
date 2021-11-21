<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use App\Models\Currencies;

class CustomUserProfileController extends UserProfileController
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
            'currencies' => Currencies::all(),
        ]);
    }
}
