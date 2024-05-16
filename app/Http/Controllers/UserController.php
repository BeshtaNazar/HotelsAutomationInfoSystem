<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Monarobase\CountryList\CountryListFacade as Countries;

class UserController extends Controller
{
    public function registerView()
    {
        $data['countries'] = Countries::getList('en');
        return view('register', $data);
    }
    public function loginView()
    {
        return view('login');
    }
    public function register(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'birthday' => 'required',
            'birthMonth' => 'required',
            'birthYear' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'country' => 'required',
            'password' => 'required',
        ]);
        $user = new User;
        $user->first_name = trim(strip_tags($request->firstName));
        $user->last_name = trim(strip_tags($request->lastName));
        $user->birthday = Carbon::parse("{$request->birthYear}-{$request->birthMonth}-{$request->birthday}");
        $user->phone = trim($request->phone);
        $user->email = trim(strip_tags($request->email));
        $user->country = trim(strip_tags($request->country));
        $user->password = Hash::make((trim(strip_tags($request->password))));
        $user->save();
        return redirect(url('login'))->with('success', 'Registration was successful.');
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended((url('account/profile')))->with('user', Auth::user());
        } else {
            return redirect(url('login'))->with('failure', 'Please enter valid credentials.');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function show()
    {
        $user = User::find(Auth::user()->id);
        $data['user'] = $user;
        $countries = Countries::getList('en');
        $data['countries'] = $countries;
        $data['isAdmin'] = $user->role == UserRole::ADMIN->value;
        return view('account/profile', $data);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->first_name = trim(strip_tags($request->firstName));
        $user->last_name = trim(strip_tags($request->lastName));
        $user->birthday = Carbon::parse("{$request->birthYear}-{$request->birthMonth}-{$request->birthday}");
        $user->phone = trim($request->phone);
        $user->email = trim(strip_tags($request->email));
        $user->country = trim(strip_tags($request->country));
        try {
            $user->save();
        } catch (\Throwable $th) {
            return redirect(url("account/profile"))->with("failed_to_update_info", "We're having some problems, please try later");
        }
        return redirect(url("account/profile"))->with("update_info_success", "Data has been successfully changed");
    }
    public function changePassword(Request $request)
    {
        if (!Hash::check($request->currentPassword, Auth::user()->password))
            return redirect(url("account/profile"))->with("wrong_password_error", "Current password is wrong");
        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        try {
            $user->save();
        } catch (\Throwable $th) {
            return redirect(url("account/profile"))->with("failed_to_change_password", "We're having some problems, please try later");
        }

        return redirect(url("account/profile"))->with("password_change_success", "Password has been successfully changed");
    }
}
