<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Afficher tous les rôles
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

    // Créer un nouveau rôle
    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array', // Permissions optionnelles
        ]);

        // Créer le rôle
        $role = Role::create([
            'name' => $request->name,
        ]);

        // Si des permissions sont fournies, les attacher au rôle
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->permissions()->attach($permissions);
        }

        return response()->json(['message' => 'Rôle créé avec succès', 'role' => $role], 201);
    }

    // Afficher un rôle spécifique
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);

        if (!$role) {
            return response()->json(['message' => 'Rôle non trouvé'], 404);
        }

        return response()->json($role);
    }

    // Mettre à jour un rôle
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Rôle non trouvé'], 404);
        }

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array', // Permissions optionnelles
        ]);

        // Mise à jour du nom du rôle
        $role->update([
            'name' => $request->name,
        ]);

        // Mise à jour des permissions si fournies
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->permissions()->sync($permissions);
        }

        return response()->json(['message' => 'Rôle mis à jour avec succès', 'role' => $role]);
    }

    // Supprimer un rôle
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Rôle non trouvé'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Rôle supprimé avec succès']);
    }
}
