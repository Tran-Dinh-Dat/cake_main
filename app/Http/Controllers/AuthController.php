<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json([
                'message' => 'Tạo tài khoản thành công!',
                'status_code' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                'status_code' => 500
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Email hoặc mật khẩu không chính xác!',
                'status_code' => 401
            ], 401);
        }
        $user = $request->user();

        if ($user->role == 'administrator') {
            $tokenData = $user->createToken('Personal Access Tokens', ['administrator']);
        } else {
            $tokenData = $user->createToken('Personal Access Tokens', ['user']);
        }

        $token = $tokenData->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeek(1);
        }

        if ($token->save()) {
            return response()->json([
                'user' => $user,
                'message' => 'Đăng nhập thành công!',
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'token_scope' => $tokenData->token->scopes[0],
                'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                'status_code' => 500
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Tài khoản đã được đăng xuất!',
            'status_code' => 200
        ], 200);
    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            return response()->json($request->user(), 200);
        } 

        return response()->json([
            'message' => 'Bạn chưa đăng nhập!',
            'status_code' => 5010
        ], 500);
    }

    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Chúng tôi đã gửi mã xác minh đến địa chỉ email của bạn',
                'status_code' => 200
            ], 200);
        } else {
            $random = rand(111111, 999999);
            $user->verification_code = $random;
            if ($user->save()) {
                $userData = array(
                    'email' => $user->email,
                    'full_name' => $user->name,
                    'verification_code' => $user->verification_code
                );
                Mail::send('emails.reset-password', $userData, function($message) use ($userData){
                    $message->to($userData['email'], $userData['full_name'] )->subject('Mã xác nhận đổi mật khẩu');
                });

                if (Mail::failures()) {
                    return response()->json([
                        'message' => 'Không gửi được mã xác nhận!',
                        'status_code' => 500
                    ], 500);
                } else {
                    return response()->json([
                        'message' => 'Đã gửi mã xác nhận, vui lòng kiểm tra email của bạn!',
                        'status_code' => 200
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'Không gửi được mã xác nhận!',
                    'status_code' => 500
                ], 500);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'verification_code' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->where('verification_code', $request->verification_code)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Email chưa được đăng ký hoặc mã xác minh không chính xác!',
                'status_code' => 401
            ], 401);
        } else {
            $user->password = bcrypt(trim($request->password));
            $user->verification_code = null;

            if ($user->save()) {
                return response()->json([
                    'message' => 'Cập nhật mật khẩu thành công!',
                    'status_code' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                    'status_code' => 500
                ], 500);
            }
        }
    }
}
