<?php
namespace Appuser\User\Services;

use Cookie;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use AppUser\User\Models\User;

/* REVIEW - Celkom cool že si si reálne implementoval vlastnú JWT logiku na expiráciu a pod. takže to je len + pre teba :DD
Keďže toto až tak nesúvisí so zadaním a OCMS tak ti to tu nebudem vypisovať všetko čo by sa dalo zmeniť, len spomeniem 1 drobnosť
Keď inde v projekte používaš camelCase pre funkcie, tak aj tu by bolo dobré použiť camelCase (nie snake_case) :D
Ale kebyže máš otázky k JWT tak kľudne daj vedieť */
class AuthService
{
    public static function create_new_jwt_token(int $userId)
    {
        $JwtTokenPayload = [
            'iss' => "AppUser/User", // Issuer
            'sub' => $userId, // Subject (user ID)
            'iat' => time(), // Issued at
            'exp' => time() + 3600 // Expiration
        ];

        $JwtToken = JWT::encode($JwtTokenPayload, env("JWT_SECRET"), "HS256");

        User::where("id", $userId)->update(["token" => $JwtToken]);

        return $JwtToken;
    }

    public static function decode_jwt_token($jwt_token)
    {
        return JWT::decode($jwt_token, new Key(env("JWT_SECRET"), "HS256"));
    }

    public static function ValidateToken(string $jwt_token)
    {
        //checks if token is nothing or if it is a jwt token (with the 2 dots) (46 is ascii code for the dot character)
        if (trim($jwt_token) == "" || count_chars($jwt_token, 1)[46] != 2) {
            return;
        }

        try {
            $decodedJwtToken = AuthService::decode_JWT_token($jwt_token);
        } catch (ExpiredException $expiredException) {
            return "expired_cookie";
        }

        $userId = $decodedJwtToken->sub;

        $userIdQuery = User::where("id", $userId)->get();

        if ($userIdQuery->isEmpty()) {
            return;
        }

        if ($userIdQuery[0]->token != $jwt_token) {
            return;
        }

        return true;
    }

    public static function get_user(string $jwt_token)
    {
        if (!AuthService::ValidateToken($jwt_token)) {
            return;
        }

        $decodedJwtToken = AuthService::decode_JWT_token($jwt_token); //JWT::decode($jwt_token, new Key(env("JWT_SECRET"), "HS256"));

        $userId = $decodedJwtToken->sub;

        $userIdQuery = User::where("id", $userId);

        return $userIdQuery;
    }

    public static function get_validated_token_from_cookie()
    {
        $tokenCookie = Cookie::get("token");
        if (!$tokenCookie) {
            return;
        }

        if (!AuthService::ValidateToken($tokenCookie)) {
            return;
        }

        return $tokenCookie;
    }

    public static function get_userid_from_cookie()
    {
        $tokenCookie = Cookie::get("token");
        if (!$tokenCookie) {
            return;
        }

        if (!AuthService::ValidateToken($tokenCookie)) {
            return;
        }

        $decodedToken = AuthService::decode_JWT_token($tokenCookie);

        return $decodedToken->sub;
    }

    public static function get_user_with_cookie()
    {
        $validatedToken = AuthService::get_validated_token_from_cookie();

        if (!$validatedToken || $validatedToken == "expired_cookie") {
            return;
        }

        return AuthService::get_user($validatedToken);
    }
}
