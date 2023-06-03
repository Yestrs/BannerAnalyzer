<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\LogsController;
use App\Models\User;



class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $log = new LogsController();
        $log->logAction('profile edited', $request->user()->username, Null);
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        $log = new LogsController();
        $log->logAction('updated profile', $request->user()->id, null);
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        $log = new LogsController();
        $log->logAction('deleted profile', $user->id, null);

        // Delete user's comments if available
        $userComments = $user->comments;
        if ($userComments) {
            foreach ($userComments as $comment) {
                $comment->delete();
            }
        }

        // Logout the user
        Auth::logout();

        // Delete the user
        $user->delete();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}