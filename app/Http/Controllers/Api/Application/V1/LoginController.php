<?php

namespace App\Http\Controllers\Api\Application\V1;

use App\Core\Extensions\Alchemy\Webhook\Models\Log;
use App\Core\Extensions\Tron\Support\Hash;
use App\Exceptions\Api\Application\V1\ApiException;
use App\Exceptions\Api\Application\V1\InvalidLoginException;
use App\Exceptions\Api\Application\V1\NotEnoughInputArguments;
use App\Exceptions\Api\Application\V1\TooManyAttemptsException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Application\V1\User as UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoginController extends Controller {
    /**
     * @throws NotEnoughInputArguments
     * @throws InvalidLoginException
     * @throws TooManyAttemptsException
     * @noinspection PhpUndefinedFieldInspection
     */
    public function login(Request $request) {
        if (!$request->username || !$request->password) {
            throw new NotEnoughInputArguments();
        }

        $username = $request->username;
        $password = $request->password;
        $rateLimiterKey = "login-$username";

        if (RateLimiter::tooManyAttempts($rateLimiterKey, $perMinute = 5) && !config('app.debug')) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);
            throw new TooManyAttemptsException('Too many attempts! You may try again in ' . $seconds . ' seconds.');
        }

        /** @var User $user */
        $user = User::role('client')->where('username', $username)->first();
        if (!$user) {
            RateLimiter::hit($rateLimiterKey);
            throw new InvalidLoginException();
        }

        if (!\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            RateLimiter::hit($rateLimiterKey);
            throw new InvalidLoginException();
        }

        $userToken = $user->createToken('application');
        $tokens = $user->tokens();
        // TODO : get maximum connections per client in database
        if ($tokens->count() > 3) {
            do {
                $tokens->oldest()->first()->delete();
            } while ($tokens->count() > 3);
        }

        return new UserResource($user, $userToken);
    }

    #[ArrayShape(['ok' => "bool", 'data' => "null", 'error' => "null"])]
    public function verifyToken(Request $request): JsonResponse {
        return response()->json(
            [
                'ok' => true,
                'data' => null,
                'error' => null
            ],
        );
    }

    /**
     * @throws NotEnoughInputArguments
     * @throws TooManyAttemptsException
     * @throws InvalidLoginException
     * @noinspection PhpUndefinedFieldInspection
     */
    #[ArrayShape(['ok' => "bool", 'data' => "null", 'error' => "null"])]
    public function changePassword(Request $request): array {
        if (!$request->currentPassword || !$request->newPassword || !$request->user()) {
            throw new NotEnoughInputArguments();
        }

        $currenPassword = $request->currentPassword;
        $newPassword = $request->newPassword;
        /** @var User $user */
        $user = $request->user();
        $rateLimiterKey = "password-change-" . $request->user()?->id;

        if (RateLimiter::tooManyAttempts($rateLimiterKey, $perMinute = 5) && !config('app.debug')) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);
            throw new TooManyAttemptsException('Too many attempts! You may try again in ' . $seconds . ' seconds.');
        }
        RateLimiter::hit($rateLimiterKey);

        if (strlen($newPassword) < 8) {
            throw new NotFoundHttpException();
        }

        if (!\Illuminate\Support\Facades\Hash::check($currenPassword, $user->password)) {
            throw new InvalidLoginException();
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($newPassword);
        $user->save();
        return [
            'ok' => true,
            'data' => [
                "message" => "Password changed successfully."
            ],
            'error' => null
        ];
    }
}
