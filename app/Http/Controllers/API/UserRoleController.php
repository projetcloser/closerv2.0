<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    // Afficher tous les rôles d'un utilisateur
    public function index($userId)
    {
        $userRoles = UserRole::where('user_id', $userId)->with('role')->get();
        return response()->json($userRoles);
    }

    // Ajouter un rôle à un utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole = UserRole::updateOrCreate(
            ['user_id' => $request->user_id, 'role_id' => $request->role_id],
            ['user_id' => $request->user_id, 'role_id' => $request->role_id]
        );

        return response()->json($userRole, 201);
    }

    // Afficher un rôle spécifique d'un utilisateur
    public function show($userId, $roleId)
    {
        $userRole = UserRole::where('user_id', $userId)->where('role_id', $roleId)->firstOrFail();
        return response()->json($userRole);
    }

    // Mettre à jour un rôle d'un utilisateur
    public function update(Request $request, $userId, $roleId)
    {
        $request->validate([
            'new_role_id' => 'required|exists:roles,id',
        ]);

        $userRole = UserRole::where('user_id', $userId)->where('role_id', $roleId)->firstOrFail();
        $userRole->role_id = $request->new_role_id;
        $userRole->save();

        return response()->json($userRole);
    }

    // Supprimer un rôle d'un utilisateur
    public function destroy($userId, $roleId)
    {
        $userRole = UserRole::where('user_id', $userId)->where('role_id', $roleId)->firstOrFail();
        $userRole->delete();

        return response()->json(['message' => 'Rôle supprimé avec succès']);
    }
}
