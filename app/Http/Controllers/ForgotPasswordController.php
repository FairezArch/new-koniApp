<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //

    public function showForgetPasswordForm()
    {
        return view('Auth.forgetpassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        // return dd($request->all());
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'Link reset password sudah dikirimkan, silahkan cek di email Anda');
    }

    public function showResetPasswordForm($token)
    {
        return view('Auth.confirmNewPassword', compact('token'));
    }

    public function submitResetPasswordForm(Request $request)
    {

        $request->validate([
            //'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                //'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

        return redirect('/login')->with('message', 'Password berhasil diganti, silahkan login');
    }
}
