<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        return redirect()->route('login.view');
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
    public function showReservations()
    {
        $activeReservations = Auth::user()->reservations()->where('status', ReservationStatus::RESERVATED->value)->where('date_to', '>=', Carbon::today())->get();
        $pastReservations = Auth::user()->reservations()->where('status', ReservationStatus::RESERVATED->value)->where('date_to', '<', Carbon::today())->get();
        $canceledReservations = Auth::user()->reservations()->where('status', ReservationStatus::CANCELED->value)->get();
        return view('reservation.index', compact(['activeReservations', 'pastReservations', 'canceledReservations']));
    }
    public function forgotPasswordView()
    {
        return view('password.forgot');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email']
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $actionLink = route('reset.password.view', ['token' => $token, 'email' => $request->email]);
        $body = "You received this email because you requested to reset your password. You can reset your password by link below";
        Mail::send('email-forgot', ['actionLink' => $actionLink, 'body' => $body], function ($message) use ($request) {
            $message->from('noreply@example.com', 'Hotels Automation');
            $message->to($request->email, 'Hotels Automation')
                ->subject('Reset password');
        });
        return back()->with('success', 'Password reset link has been sent');
    }
    public function resetPasswordView(Request $request, $token = null)
    {
        return view('password.reset')->with(['token' => $token, 'email' => $request->email]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => 'required'
        ]);
        $isRightData = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();
        if (!$isRightData) {
            return back()->withInput()->with('failure', 'Invalid token');
        } else {
            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);
            DB::table('password_resets')->where([
                'email' => $request->email,
            ])->delete();
        }
        return redirect('login')->with('success', 'Password has been changed');
    }
}
