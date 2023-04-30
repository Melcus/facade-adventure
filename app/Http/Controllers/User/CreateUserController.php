<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Services\Galactus\Facades\Galactus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        $kid = Galactus::getKid($request->get('email'));

        $user = User::create(
            array_merge(
                $request->only('email', 'name'),
                [
                    'kid' => $kid,
                    'password' => bcrypt($request->get('password')),
                ]
            )
        );

        Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json($user, Response::HTTP_CREATED);
    }
}
