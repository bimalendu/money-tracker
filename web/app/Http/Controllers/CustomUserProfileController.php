<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $data = Cache::get('currencies', function () {
            return Currencies::select('currency_code','currency')->distinct()->get();
        });

        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
            'currencies' => $data,
        ]);
    }
}
