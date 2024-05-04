<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user): JsonResponse
    {
        return response()->json($user->paginate(5));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $userRequest): JsonResponse
    {
        $user = User::create([
            'phone_number' => $userRequest->userAllowedInputs()['phoneNumber'],
        ]);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $userRequest,User $user): JsonResponse
    {
        $user->update([
            'phone_number' => $userRequest->userAllowedInputs()['phoneNumber'],
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->forceDelete();

        return response()->json([
            'status' => '200',
            'message' => 'user is deleted',
        ]);
    }
}
