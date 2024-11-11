<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Http\Requests\Api\v1\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    use ApiResponses;
    /**
     * Login the user
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('There was a problem with your credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        $token = $user->createToken('API token for ' . $user->email);

        return $this->ok(
            'Authenticated',
            [
                'token' => $token->plainTextToken
            ]
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if($validated) {
            User::create($validated);
        }

        return $this->ok('Register successful', $request->email);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
