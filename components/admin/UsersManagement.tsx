'use client';
import { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

interface User {
  id: string;
  full_name: string;
  role: string;
}

interface UsersManagementProps {
  currentUser: User;
}

export default function UsersManagement({ currentUser }: UsersManagementProps) {
  const supabase = createClient();
  const qc = useQueryClient();

  const [searchTerm, setSearchTerm] = useState('');
  const [roleFilter, setRoleFilter] = useState('');
  const [editingUser, setEditingUser] = useState<any | null>(null);

  const { data: users, isLoading } = useQuery({
    queryKey: ['all-users'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('users')
        .select('*, ligues(name), etablissements(name)')
        .order('created_at', { ascending: false });

      if (error) throw error;
      return data;
    },
  });

  const { data: ligues } = useQuery({
    queryKey: ['ligues-list'],
    queryFn: async () => {
      const { data, error } = await supabase.from('ligues').select('*').order('name');
      if (error) throw error;
      return data;
    },
  });

  const { data: etablissements } = useQuery({
    queryKey: ['etablissements-list'],
    queryFn: async () => {
      const { data, error } = await supabase.from('etablissements').select('*, ligues(name)').order('name');
      if (error) throw error;
      return data;
    },
  });

  const updateUser = useMutation({
    mutationFn: async ({ id, updates }: { id: string; updates: any }) => {
      const { error } = await supabase
        .from('users')
        .update(updates)
        .eq('id', id);

      if (error) throw error;
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: ['all-users'] });
      setEditingUser(null);
    },
  });

  const toggleUserStatus = useMutation({
    mutationFn: async ({ id, is_active }: { id: string; is_active: boolean }) => {
      const { error } = await supabase
        .from('users')
        .update({ is_active: !is_active })
        .eq('id', id);

      if (error) throw error;
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: ['all-users'] });
    },
  });

  const filteredUsers = users?.filter((user: any) => {
    const matchesSearch =
      user.full_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      user.email.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesRole = !roleFilter || user.role === roleFilter;

    return matchesSearch && matchesRole;
  });

  const getRoleBadgeClass = (role: string) => {
    switch (role) {
      case 'SUPERADMIN':
        return 'bg-purple-100 text-purple-800';
      case 'ADMIN':
        return 'bg-red-100 text-red-800';
      case 'ADMIN_LIGUE':
        return 'bg-orange-100 text-orange-800';
      case 'COACH':
        return 'bg-blue-100 text-blue-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  const getRoleLabel = (role: string) => {
    switch (role) {
      case 'SUPERADMIN':
        return 'Super Admin';
      case 'ADMIN':
        return 'Administrateur';
      case 'ADMIN_LIGUE':
        return 'Admin Ligue';
      case 'COACH':
        return 'Coach';
      case 'ELEVE':
        return 'Élève';
      default:
        return role;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16 items-center">
            <div className="flex items-center space-x-4">
              <Link href="/select-module" className="text-blue-600 hover:text-blue-800 font-medium">
                ← Retour
              </Link>
              <h1 className="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h1>
            </div>
            <div className="flex items-center space-x-3">
              <span className="text-sm text-gray-600">{currentUser.full_name}</span>
              <span className={`px-3 py-1 rounded-full text-xs font-medium ${getRoleBadgeClass(currentUser.role)}`}>
                {getRoleLabel(currentUser.role)}
              </span>
            </div>
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="bg-white rounded-xl shadow-md border p-6 mb-6">
          <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div className="flex-1">
              <input
                type="text"
                placeholder="Rechercher par nom ou email..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              />
            </div>
            <div>
              <select
                value={roleFilter}
                onChange={(e) => setRoleFilter(e.target.value)}
                className="px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
                <option value="">Tous les rôles</option>
                <option value="SUPERADMIN">Super Admin</option>
                <option value="ADMIN">Administrateur</option>
                <option value="ADMIN_LIGUE">Admin Ligue</option>
                <option value="COACH">Coach</option>
              </select>
            </div>
          </div>
        </div>

        {isLoading ? (
          <div className="flex justify-center items-center h-64">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          </div>
        ) : (
          <div className="bg-white rounded-xl shadow-md border overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Utilisateur
                    </th>
                    <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Rôle
                    </th>
                    <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Ligue
                    </th>
                    <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Établissement
                    </th>
                    <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Statut
                    </th>
                    <th className="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-200">
                  {filteredUsers?.map((user: any) => (
                    <tr key={user.id} className="hover:bg-gray-50 transition">
                      <td className="px-6 py-4">
                        <div>
                          <div className="font-semibold text-gray-900">{user.full_name}</div>
                          <div className="text-sm text-gray-600">{user.email}</div>
                        </div>
                      </td>
                      <td className="px-6 py-4">
                        <span className={`px-3 py-1 rounded-full text-xs font-medium ${getRoleBadgeClass(user.role)}`}>
                          {getRoleLabel(user.role)}
                        </span>
                      </td>
                      <td className="px-6 py-4 text-sm text-gray-700">
                        {user.ligues?.name || '-'}
                      </td>
                      <td className="px-6 py-4 text-sm text-gray-700">
                        {user.etablissements?.name || '-'}
                      </td>
                      <td className="px-6 py-4">
                        <span
                          className={`px-3 py-1 rounded-full text-xs font-medium ${
                            user.is_active
                              ? 'bg-green-100 text-green-800'
                              : 'bg-gray-100 text-gray-800'
                          }`}
                        >
                          {user.is_active ? 'Actif' : 'Inactif'}
                        </span>
                      </td>
                      <td className="px-6 py-4 text-right">
                        <div className="flex justify-end space-x-2">
                          <button
                            onClick={() => setEditingUser(user)}
                            className="text-blue-600 hover:text-blue-800 font-medium text-sm"
                          >
                            Modifier
                          </button>
                          <button
                            onClick={() => toggleUserStatus.mutate({ id: user.id, is_active: user.is_active })}
                            disabled={user.id === currentUser.id || toggleUserStatus.isPending}
                            className="text-gray-600 hover:text-gray-800 font-medium text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                          >
                            {user.is_active ? 'Désactiver' : 'Activer'}
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}

                  {(!filteredUsers || filteredUsers.length === 0) && (
                    <tr>
                      <td colSpan={6} className="px-6 py-12 text-center text-gray-500">
                        Aucun utilisateur trouvé
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        )}

        {editingUser && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div className="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
              <h3 className="text-xl font-bold text-gray-900 mb-4">Modifier l'utilisateur</h3>

              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                  <select
                    value={editingUser.role}
                    onChange={(e) => setEditingUser({ ...editingUser, role: e.target.value })}
                    className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                  >
                    <option value="COACH">Coach</option>
                    <option value="ADMIN_LIGUE">Admin Ligue</option>
                    <option value="ADMIN">Administrateur</option>
                    <option value="SUPERADMIN">Super Admin</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Ligue</label>
                  <select
                    value={editingUser.ligue_id || ''}
                    onChange={(e) => setEditingUser({ ...editingUser, ligue_id: e.target.value || null })}
                    className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                  >
                    <option value="">Aucune</option>
                    {ligues?.map((ligue: any) => (
                      <option key={ligue.id} value={ligue.id}>
                        {ligue.name}
                      </option>
                    ))}
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Établissement</label>
                  <select
                    value={editingUser.etablissement_id || ''}
                    onChange={(e) => setEditingUser({ ...editingUser, etablissement_id: e.target.value || null })}
                    className="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                  >
                    <option value="">Aucun</option>
                    {etablissements?.map((etab: any) => (
                      <option key={etab.id} value={etab.id}>
                        {etab.name}
                      </option>
                    ))}
                  </select>
                </div>
              </div>

              <div className="flex space-x-3 mt-6">
                <button
                  onClick={() => setEditingUser(null)}
                  className="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition"
                >
                  Annuler
                </button>
                <button
                  onClick={() => updateUser.mutate({
                    id: editingUser.id,
                    updates: {
                      role: editingUser.role,
                      ligue_id: editingUser.ligue_id || null,
                      etablissement_id: editingUser.etablissement_id || null,
                    }
                  })}
                  disabled={updateUser.isPending}
                  className="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition disabled:opacity-50"
                >
                  {updateUser.isPending ? 'Enregistrement...' : 'Enregistrer'}
                </button>
              </div>
            </div>
          </div>
        )}
      </main>
    </div>
  );
}
