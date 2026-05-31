<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'email.email' => 'Invalid email format.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalide credentials.',
        ])->onlyInput('email');
    }



    public function showRegistrationForm()
    {
        return view('register');
    }

    // Handle registration
    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact' => ['nullable', 'string', 'max:20', 'unique:users,contact'],
            'image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'agree'    => ['required'],
        ], [
            'name.required'  => 'Name is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'contact.required' => 'Contact number is required.',
            'agree.required' => 'You must agree to the terms.',
            'contact.unique' => 'This contact number is already registered.',
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $imageName);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'contact'  => $request->contact,
            'image'    => $imageName,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }


    // dashboard function 
    public function dashboard()
    {
        $userId = Auth::id();

        // Categories Count
        $categoriesCount = Category::where('user_id', $userId)->count();


        // Total Income
        $totalIncome = Transaction::where('user_id', $userId)
            ->whereHas('category', function ($query) {

                $query->where('type', 'income');
            })->sum('amount');


        // Total Expense
        $totalExpense = Transaction::where('user_id', $userId)
            ->whereHas('category', function ($query) {

                $query->where('type', 'expense');
            })->sum('amount');


        // Balance
        $balance = $totalIncome - $totalExpense;


        // Months
        $months = collect(range(1, 12));


        // Labels
        $monthlyLabels = $months->map(function ($m) {

            return date('M', mktime(0, 0, 0, $m, 1));
        })->toArray();


        // Monthly Income
        $monthlyIncome = $months->map(function ($m) use ($userId) {

            return Transaction::where('user_id', $userId)
                ->whereHas('category', function ($query) {

                    $query->where('type', 'income');
                })
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
        })->toArray();


        // Monthly Expense
        $monthlyExpense = $months->map(function ($m) use ($userId) {

            return Transaction::where('user_id', $userId)
                ->whereHas('category', function ($query) {

                    $query->where('type', 'expense');
                })
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
        })->toArray();


        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'categoriesCount',
            'monthlyLabels',
            'monthlyIncome',
            'monthlyExpense'
        ));
    }


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
