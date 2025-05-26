<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the dashboard with recent orders.
     */
    public function dashboard()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->limit(5) // Show only recent 5 orders
                       ->get();
        
        return view('dashboard', compact('orders'));
    }

    /**
     * Display the user's profile with orders.
     */
    public function index(Request $request)
{
    $user = $request->user();

    $orders = Order::where('user_id', $user->id)
                   ->orderBy('created_at', 'desc')
                   ->limit(5)
                   ->get();

    // Load favorites with product relation
    $favorites = $user->favorites()->with('product')->get();

    return view('profile.index', [
        'user' => $user,
        'orders' => $orders,
        'favorites' => $favorites,
    ]);
}


    /**
     * Display paginated orders for the user.
     */
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
        
        return view('profile.orders', compact('orders'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show user profile with all orders.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders()->latest()->get();

        return view('profile.show', compact('user', 'orders'));
    }
    
}