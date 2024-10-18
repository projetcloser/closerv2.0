<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'matricule' => 'required|string|max:255',  // matricule
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            'persoId' => 'required|integer',  // id_perso
            'roleId' => 'required|integer',  // Vérifier que le roleId existe dans la table roles
        ]);




        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Étape 2 : Vérifier si le matricule existe déjà
        $existingUser = User::where('name', $request->matricule)->first();

        if ($existingUser) {
            return response()->json(['message' => 'Un compte existe déjà avec ce matricule'], 409); // Conflict HTTP status
        }

        // Étape 3 : Récupérer les champs firstname et lastname depuis la table members en fonction du persoId
        $member = DB::table('members')->where('id', $request->persoId)->first();

        if (!$member) {
            return response()->json(['message' => 'Aucun membre trouvé avec cet id_perso'], 404); // Not found
        }

        $name = $member->lastname . ' ' . $member->firstname;  // Concaténer le nom complet

        // Étape 3 : Enregistrer l'utilisateur dans la table users
        $user = User::create([
            'name' => $name,  // Nom complet obtenu des membres
            'username' => $request->matricule,  // Sauvegarder le matricule dans le champ username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_perso' => $request->persoId  // id_perso
        ]);

        // Générer un jeton Passport pour l'utilisateur
       $token = $user->createToken('andy')->accessToken;

//        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
//            'grant_type' => 'password',
//            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
//            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
//            'username' => $request->email,
//            'password' => Hash::make($request->password),
//            'scope' => '',
//        ]);

        // $user['token'] = $response->json();

        // Étape 4 : Récupérer l'id du dernier utilisateur et sauvegarder dans la table user_roles
        $userId = $user->id;
        UserRole::create([
            'user_id' => $userId,
            'role_id' => $request->roleId,  // roleId
        ]);

      //  return response()->json(['message' => 'Utilisateur enregistré avec succès!'], 201);



        $role = DB::table('roles')->where('id', $request->roleId)->first();

        if (!$role) {
            return response()->json(['message' => 'Aucun Role trouvé avec cet id_perso'], 404); // Not found
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'statusCode' => 201,
            'message' => 'User has been registered successfully.',
            'data' => $user,
            'role' => $role,
            'perso' => $member,
        ], 201);


    }


    public function registerStaff(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'matricule' => 'required|string|max:255',  // matricule
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            'persoId' => 'required|integer',  // id_perso
            'roleId' => 'required|integer',  // Vérifier que le roleId existe dans la table roles
        ]);




        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Étape 2 : Vérifier si le matricule existe déjà
        $existingUser = User::where('name', $request->matricule)->first();

        if ($existingUser) {
            return response()->json(['message' => 'Un compte existe déjà avec ce matricule'], 409); // Conflict HTTP status
        }

        // Étape 3 : Récupérer les champs firstname et lastname depuis la table members en fonction du persoId
        $staff = DB::table('staffs')->where('id', $request->persoId)->first();

        if (!$staff) {
            return response()->json(['message' => 'Aucun membre trouvé avec cet id_perso'], 404); // Not found
        }

        $name = $staff->lastname . ' ' . $staff->firstname;  // Concaténer le nom complet

        // Étape 3 : Enregistrer l'utilisateur dans la table users
        $user = User::create([
            'name' => $name,  // Nom complet obtenu des membres
            'username' => $request->matricule,  // Sauvegarder le matricule dans le champ username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_perso' => $request->persoId  // id_perso
        ]);

        // Générer un jeton Passport pour l'utilisateur
        $token = $user->createToken('andy')->accessToken;

//        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
//            'grant_type' => 'password',
//            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
//            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
//            'username' => $request->email,
//            'password' => Hash::make($request->password),
//            'scope' => '',
//        ]);

        // $user['token'] = $response->json();

        // Étape 4 : Récupérer l'id du dernier utilisateur et sauvegarder dans la table user_roles
        $userId = $user->id;
        UserRole::create([
            'user_id' => $userId,
            'role_id' => $request->roleId,  // roleId
        ]);

        $role = DB::table('roles')->where('id', $request->roleId)->first();

        if (!$role) {
            return response()->json(['message' => 'Aucun Role trouvé avec cet id_perso'], 404); // Not found
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'statusCode' => 201,
            'message' => 'User has been registered successfully.',
            'data' => $user,
            'role' => $role,
            'perso' => $staff,
        ], 201);


    }

    public function login(Request $request)
    {
        // Validation des données d'entrée
        $credentials = $request->only('matricule', 'password');

        // On vérifie si l'utilisateur existe avec le matricule et le mot de passe
        if (Auth::attempt(['username' => $credentials['matricule'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            $perso = DB::table('staffs')
                ->where('id', $user->id_perso)
                ->first();

            if (!$perso) {
                $perso = DB::table('members')
                    ->where('id', $user->id_perso)
                    ->first();
            }

            $userrole = DB::table('user_roles')->where('user_id', $user->id)->first();

            $role = DB::table('roles')->where('id', $userrole->role_id)->first();

            if (!$role) {
                return response()->json(['message' => 'Aucun Role trouvé avec cet id_perso'], 404); // Not found
            }

            $token = $user->createToken('andy')->accessToken;

            // Générer un token aléatoire pour l'utilisateur
            $tokenId = Str::random(80);
            $user->update(['remember_token' => $tokenId]);


            // Retourner une réponse avec le token et les informations de l'utilisateur
            return response()->json(['tokenId' => $tokenId,'token' => $token, 'user' => $user, 'perso' => $perso, 'role'=> $role], 200);
        }

        // Retourner une réponse Unauthorized si les informations sont incorrectes
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function forgotPassword(Request $request)
    {
        // Validation des données
        $request->validate([
            'matricule' => 'required|string',
            'email' => 'required|string|email',
        ]);

        // Étape 2 : Vérifier si le matricule et l'adresse email correspondent à un utilisateur
        $user = User::where('name', $request->matricule)->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Votre matricule ou email est incorrect'], 404);
        }

        // Étape 3 : Générer un token de réinitialisation de mot de passe
        $token = Str::random(60);

        // Sauvegarder le token dans la table password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Envoyer un email avec le lien de réinitialisation du mot de passe
        Mail::send('emails.reset_password', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Réinitialisation du mot de passe');
        });

        return response()->json(['message' => 'Un email de réinitialisation de mot de passe a été envoyé.'], 200);
    }

    public function logout(Request $request)
    {
        // Récupération de l'utilisateur authentifié
        $user = Auth::user();

        if ($user) {
            // Vérification si le token est encore valide ou révoqué
            $accessToken = $user->token();  // Récupère le token en cours

            if ($accessToken->revoked) {
                // Si le token est déjà révoqué
                return response()->json([
                    'success' => false,
                    'statusCode' => 401,
                    'message' => 'Token expired',
                ], 401);
            }

            // Révocation du token et suppression des autres tokens associés
            $user->update(['remember_token' => null]);
            $user->tokens()->delete();  // Révoquer tous les tokens de l'utilisateur

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Logged out successfully.',
            ], 200);
        } else {
            // Gestion du cas où l'utilisateur n'est pas authentifié ou token invalide
            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'message' => 'User not authenticated or token invalid',
            ], 401);
        }
    }


    public function user()
    {
        return response()->json(auth()->user());
    }
}
