<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MailHelper;
use App\Rules\IsAllowedDomain;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Create a new user instance after a valid registration.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    protected function create(Request $request)
    {
        $data = $request->only('email', 'name', 'password');

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return Response::json(
                [
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()->toArray()
                ],
                422
            );
        }

        $user = null;

        if ($email = $request->get('email')) {
            $user = User::where('email', $email)->withTrashed()->first();
        }

        if (!$user) {
            /** @var User $user */
            $user = User::forceCreate([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'locale' => $request->getLocale()
            ]);
        } else {
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password'  => Hash::make($data['password']),
                'locale'    => $request->getLocale(),
                'deleted_at' => null
            ]);
        }

        $user->save();
        $user->oldPasswords()->create(['password' => $user->password]);

        return Response::json([
            'message' => $isBetaUser
                ? __('You are added to Beta users list and you will be informed when Beta version is live')
                : __('Verification email has been sent')
        ]);
    }
}
