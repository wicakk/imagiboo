<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginByGoogle(Request $request)
    {
        $uid = $request->uid;
        $name = $request->name;
        $email = $request->email;

        $user = User::firstOrCreate(
            ['uid' => $uid],
            [
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($uid)
            ]
        );

        Auth::loginUsingId($user->id);

        return response()->json([
            'status' => 'success',
            'redirect' => '/'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
