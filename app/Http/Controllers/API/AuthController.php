<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Register new user
     * 
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Invalid Email or Password'], 401);
        }
        return $this->respondWithToken($token);
    }

    // public function login(Request $request)
    // {
    //     try {
    //         if (! $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //             return response()->json(['error' => 'invalid_credentials'], 401);
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['error' => 'could_not_create_token'], 500);
    //     }

    //     return $this->respondWithToken($token);


    //     return response()->json(compact('token'));
    // }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function test(){
        return response()->json(['message' => 'Successfully logged out']);
        
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'username' => Auth::user()->name,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 360000
        ]);
    }


    public function validatePasswordRequest(Request $request)
    {
        Log::info($request->email);
        $request->validate([
          'email' => 'required|email|exists:users',
      ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
          'email' => $request->email, 
          'token' => $token, 
          'created_at' => Carbon::now()
      ]);

        $response = Mail::send('mail.forgot_password', ['token' => $token], function($message) use($request){
          $message->to($request->email);
          $message->subject('Reset Password');
      });

        return response()->json("Email sent with reset link", 200);
    }


    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $updatePassword = DB::table('password_resets')
        ->where([
            'email' => $request->email, 
            'token' => $request->token
        ])
        ->first();

        if(!$updatePassword){
          return back()->withInput()->with('error', 'Invalid token!');
      }

      $user = User::where('email', $request->email)
      ->update(['password' => Hash::make($request->password)]);

      DB::table('password_resets')->where(['email'=> $request->email])->delete();

      return response()->json("Your password has been changed!", 200);

  }
}
