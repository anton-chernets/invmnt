<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

class UserAuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="register.",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="name",
     *         description="name",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             example="Anton",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         description="email",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             example="anton.fullstack@gmail.com",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         description="password",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             example="password",
     *         ),
     *     ),
     *     @OA\Response(
     *          description="register.",
     *          response=200,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @OA\Property(
     *                   property="data",
     *                   type="object",
     *                   example={
     *                       "name": "Anton",
     *                       "email": "anton.fullstack@gmail.com",
     *                       "updated_at": "2024-02-03T16:53:20.000000Z",
     *                       "created_at": "2024-02-03T16:53:20.000000Z"
     *                   }
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $registerUserData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        return response()->json([
            'success' => true,
            'data' => UserResource::make($user),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="login.",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="email",
     *         description="email",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             example="anton.fullstack@gmail.com",
     *         ),
     *     ),
     *      @OA\Parameter(
     *          name="password",
     *          description="password",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Tomas1989",
     *          ),
     *      ),
     *      @OA\Response(
     *          description="Display current token.",
     *          response=200,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  example={
     *                      "access_token": "Bearer 2|NdjBByPTcx9DzQgSN8x7dq3DUtjDLmEbwNQqvPGEfdb4e5db"
     *                  }
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'data' => [
                'access_token' => 'Bearer ' . $token,
            ],
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="logout.",
     *     tags={"User"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *          description="logout.",
     *          response=200,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *              )
     *          )
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Display current user.",
     *     tags={"User"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         description="Display current user.",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="data",
     *                   type="object",
     *                   example={
     *                       "name": "Anton",
     *                       "email": "anton.fullstack@gmail.com",
     *                       "role": "Admin",
     *                       "updated_at": "2024-02-03T16:53:20.000000Z",
     *                       "created_at": "2024-02-03T16:53:20.000000Z",
     *                   }
     *             )
     *         )
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'data' => UserResource::make($request->user())
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/remove",
     *     summary="remove current user.",
     *     tags={"User"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         description="remove current user.",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="success",
     *                   type="boolean",
     *                   example=true
     *             )
     *         )
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        return response()->json([
            'success' => !($request->user()->hasRole('Admin')) && $request->user()->delete(),
        ]);
    }
}
