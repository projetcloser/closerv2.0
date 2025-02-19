<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Étape 1: Envoyer un OTP au mail
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matricule' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Vérifier si l'utilisateur existe avec l'email et le username
        $user = DB::table('users')
            ->where('username', $request->matricule)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            //return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
            //update l'email de l'utilisateur avec le matricule
            DB::table('users')
                ->where('username', $request->matricule)
                ->update([
                    'email' => $request->email,
                    'updated_at' => now(),
                ]);

            $user = DB::table('users')
                ->where('username', $request->matricule)
                ->where('email', $request->email)
                ->first();
        }

        // Générer un OTP
        $otp = rand(100000, 999999);
        //Générer un OTP qui sera stocké comme string
        $otp = strval($otp);

        // Enregistrer ou mettre à jour le OTP dans une table temporaire
        DB::table('users')
            ->where('username', $request->matricule)
            ->where('email', $request->email)
            ->update([
                'remember_token' => $otp,
                'updated_at' => now(),
            ]);

        // Envoyer l'OTP par mail
        Mail::raw(
            "Votre code de réinitialisation est : $otp",
            function ($message) use ($request) {
                $message->to($request->email)->subject('Code de réinitialisation');
            }
        );

        return response()->json(['message' => 'Un code de vérification a été envoyé à votre adresse email.']);
    }

    /**
     * Étape 2: Vérifier l'OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Vérifier si l'OTP est valide
        $otpRecord = DB::table('users')
            ->where('email', $request->email)
            ->where('remember_token', $request->otp)
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Code de vérification invalide ou expiré.'], 400);
        }

        return response()->json(['message' => 'Code de vérification validé.']);
    }

    /**
     * Étape 3: Réinitialiser le mot de passe
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'newPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Vérifier si l'utilisateur existe
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        // Réinitialiser le mot de passe
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->newPassword)]);

        return response()->json(['message' => 'Mot de passe réinitialisé avec succès.']);
    }
}
