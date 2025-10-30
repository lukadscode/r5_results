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

interface RameAdminProps {
  user: User;
}

export default function RameAdmin({ user }: RameAdminProps) {
  const supabase = createClient();
  const qc = useQueryClient();

  const [activeTab, setActiveTab] = useState<'saisons' | 'ligues' | 'etablissements' | 'validation'>('saisons');

  const [saisonForm, setSaisonForm] = useState({ name: '', start_date: '', end_date: '' });
  const [ligueForm, setLigueForm] = useState({ name: '', code: '', region: '' });
  const [etablissementForm, setEtablissementForm] = useState({
    name: '',
    type: 'CLUB',
    ligue_id: '',
    city: '',
    postal_code: '',
  });

  const { data: saisons } = useQuery({
    queryKey: ['admin-saisons'],
    queryFn: async () => {
      const { data, error } = await supabase.from('saisons').select('*').order('start_date', { ascending: false });
      if (error) throw error;
      return data;
    },
  });

  const { data: ligues } = useQuery({
    queryKey: ['admin-ligues'],
    queryFn: async () => {
      const { data, error } = await supabase.from('ligues').select('*').order('name');
      if (error) throw error;
      return data;
    },
  });

  const { data: etablissements } = useQuery({
    queryKey: ['admin-etablissements'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('etablissements')
        .select('*, ligues(name)')
        .order('name');
      if (error) throw error;
      return data;
    },
  });

  const { data: pendingClasses } = useQuery({
    queryKey: ['pending-classes'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('classes')
        .select('*, etablissements(name), saisons(name), users!classes_coach_id_fkey(full_name)')
        .eq('status', 'SUBMITTED')
        .order('created_at', { ascending: false });
      if (error) throw error;
      return data;
    },
  });

  const createSaison = useMutation({
    mutationFn: async () => {
      const { error } = await supabase.from('saisons').insert(saisonForm);
      if (error) throw error;
    },
    onSuccess: () => {
      setSaisonForm({ name: '', start_date: '', end_date: '' });
      qc.invalidateQueries({ queryKey: ['admin-saisons'] });
    },
  });

  const toggleActiveSaison = useMutation({
    mutationFn: async ({ id, is_active }: { id: string; is_active: boolean }) => {
      const { error } = await supabase.from('saisons').update({ is_active: !is_active }).eq('id', id);
      if (error) throw error;
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: ['admin-saisons'] });
      qc.invalidateQueries({ queryKey: ['active-saison'] });
    },
  });

  const createLigue = useMutation({
    mutationFn: async () => {
      const { error } = await supabase.from('ligues').insert(ligueForm);
      if (error) throw error;
    },
    onSuccess: () => {
      setLigueForm({ name: '', code: '', region: '' });
      qc.invalidateQueries({ queryKey: ['admin-ligues'] });
    },
  });

  const createEtablissement = useMutation({
    mutationFn: async () => {
      const { error } = await supabase.from('etablissements').insert(etablissementForm);
      if (error) throw error;
    },
    onSuccess: () => {
      setEtablissementForm({ name: '', type: 'CLUB', ligue_id: '', city: '', postal_code: '' });
      qc.invalidateQueries({ queryKey: ['admin-etablissements'] });
    },
  });

  const validateClasse = useMutation({
    mutationFn: async (classeId: string) => {
      const { error } = await supabase
        .from('classes')
        .update({
          status: 'VALIDATED',
          validated_at: new Date().toISOString(),
          validated_by: user.id,
        })
        .eq('id', classeId);
      if (error) throw error;
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: ['pending-classes'] });
    },
  });

  return (
    <div className="min-h-screen bg-gray-50">
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16 items-center">
            <div className="flex items-center space-x-4">
              <Link href="/rame/dashboard" className="text-blue-600 hover:text-blue-800 font-medium">
                ← Retour au Dashboard
              </Link>
              <h1 className="text-2xl font-bold text-gray-900">Administration Rame en 5e</h1>
            </div>
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="bg-white rounded-lg shadow-sm border mb-6">
          <div className="flex border-b overflow-x-auto">
            <button
              onClick={() => setActiveTab('saisons')}
              className={`px-6 py-4 font-medium whitespace-nowrap transition ${
                activeTab === 'saisons'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Saisons
            </button>
            <button
              onClick={() => setActiveTab('ligues')}
              className={`px-6 py-4 font-medium whitespace-nowrap transition ${
                activeTab === 'ligues'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Ligues
            </button>
            <button
              onClick={() => setActiveTab('etablissements')}
              className={`px-6 py-4 font-medium whitespace-nowrap transition ${
                activeTab === 'etablissements'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Établissements
            </button>
            <button
              onClick={() => setActiveTab('validation')}
              className={`px-6 py-4 font-medium whitespace-nowrap transition ${
                activeTab === 'validation'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Validation Classes {pendingClasses && pendingClasses.length > 0 && (
                <span className="ml-2 px-2 py-0.5 bg-red-500 text-white rounded-full text-xs">
                  {pendingClasses.length}
                </span>
              )}
            </button>
          </div>

          <div className="p-6">
            {activeTab === 'saisons' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Créer une saison</h2>
                <div className="grid md:grid-cols-3 gap-4 mb-8">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input
                      type="text"
                      value={saisonForm.name}
                      onChange={(e) => setSaisonForm({ ...saisonForm, name: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Ex: 2024-2025"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Date début *</label>
                    <input
                      type="date"
                      value={saisonForm.start_date}
                      onChange={(e) => setSaisonForm({ ...saisonForm, start_date: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Date fin *</label>
                    <input
                      type="date"
                      value={saisonForm.end_date}
                      onChange={(e) => setSaisonForm({ ...saisonForm, end_date: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    />
                  </div>

                  <button
                    onClick={() => createSaison.mutate()}
                    disabled={!saisonForm.name || !saisonForm.start_date || !saisonForm.end_date || createSaison.isPending}
                    className="md:col-span-3 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg disabled:opacity-50"
                  >
                    {createSaison.isPending ? 'Création...' : 'Créer la saison'}
                  </button>
                </div>

                <h3 className="text-lg font-bold mb-4">Saisons existantes</h3>
                <div className="space-y-2">
                  {saisons?.map((saison) => (
                    <div key={saison.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                      <div>
                        <div className="font-semibold">{saison.name}</div>
                        <div className="text-sm text-gray-600">
                          {new Date(saison.start_date).toLocaleDateString('fr-FR')} -{' '}
                          {new Date(saison.end_date).toLocaleDateString('fr-FR')}
                        </div>
                      </div>

                      <button
                        onClick={() => toggleActiveSaison.mutate({ id: saison.id, is_active: saison.is_active })}
                        className={`px-4 py-2 rounded-lg font-medium transition ${
                          saison.is_active
                            ? 'bg-green-100 text-green-700 hover:bg-green-200'
                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        }`}
                      >
                        {saison.is_active ? 'Active' : 'Inactive'}
                      </button>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {activeTab === 'ligues' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Créer une ligue</h2>
                <div className="grid md:grid-cols-3 gap-4 mb-8">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input
                      type="text"
                      value={ligueForm.name}
                      onChange={(e) => setLigueForm({ ...ligueForm, name: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Ex: Ligue Île-de-France"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Code *</label>
                    <input
                      type="text"
                      value={ligueForm.code}
                      onChange={(e) => setLigueForm({ ...ligueForm, code: e.target.value.toUpperCase() })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Ex: IDF"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Région</label>
                    <input
                      type="text"
                      value={ligueForm.region}
                      onChange={(e) => setLigueForm({ ...ligueForm, region: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Île-de-France"
                    />
                  </div>

                  <button
                    onClick={() => createLigue.mutate()}
                    disabled={!ligueForm.name || !ligueForm.code || createLigue.isPending}
                    className="md:col-span-3 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg disabled:opacity-50"
                  >
                    {createLigue.isPending ? 'Création...' : 'Créer la ligue'}
                  </button>
                </div>

                <h3 className="text-lg font-bold mb-4">Ligues existantes</h3>
                <div className="space-y-2">
                  {ligues?.map((ligue) => (
                    <div key={ligue.id} className="p-4 bg-gray-50 rounded-lg">
                      <div className="font-semibold">{ligue.name}</div>
                      <div className="text-sm text-gray-600">
                        Code: {ligue.code} {ligue.region && `• ${ligue.region}`}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {activeTab === 'etablissements' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Créer un établissement</h2>
                <div className="grid md:grid-cols-2 gap-4 mb-8">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input
                      type="text"
                      value={etablissementForm.name}
                      onChange={(e) => setEtablissementForm({ ...etablissementForm, name: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Ex: Collège Victor Hugo"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                    <select
                      value={etablissementForm.type}
                      onChange={(e) => setEtablissementForm({ ...etablissementForm, type: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                      <option value="CLUB">Club</option>
                      <option value="COLLEGE">Collège</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Ligue *</label>
                    <select
                      value={etablissementForm.ligue_id}
                      onChange={(e) => setEtablissementForm({ ...etablissementForm, ligue_id: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                      <option value="">Sélectionner une ligue</option>
                      {ligues?.map((ligue) => (
                        <option key={ligue.id} value={ligue.id}>
                          {ligue.name}
                        </option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                    <input
                      type="text"
                      value={etablissementForm.city}
                      onChange={(e) => setEtablissementForm({ ...etablissementForm, city: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    />
                  </div>

                  <div className="md:col-span-2">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                    <input
                      type="text"
                      value={etablissementForm.postal_code}
                      onChange={(e) => setEtablissementForm({ ...etablissementForm, postal_code: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    />
                  </div>

                  <button
                    onClick={() => createEtablissement.mutate()}
                    disabled={!etablissementForm.name || !etablissementForm.ligue_id || createEtablissement.isPending}
                    className="md:col-span-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg disabled:opacity-50"
                  >
                    {createEtablissement.isPending ? 'Création...' : 'Créer l\'établissement'}
                  </button>
                </div>

                <h3 className="text-lg font-bold mb-4">Établissements existants</h3>
                <div className="space-y-2">
                  {etablissements?.map((etab: any) => (
                    <div key={etab.id} className="p-4 bg-gray-50 rounded-lg">
                      <div className="font-semibold">{etab.name}</div>
                      <div className="text-sm text-gray-600">
                        {etab.type} • {etab.ligues?.name}
                        {etab.city && ` • ${etab.city}`}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {activeTab === 'validation' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Classes en attente de validation</h2>

                {pendingClasses && pendingClasses.length > 0 ? (
                  <div className="space-y-4">
                    {pendingClasses.map((classe: any) => (
                      <div key={classe.id} className="border border-gray-200 rounded-lg p-6">
                        <div className="flex items-start justify-between">
                          <div className="flex-1">
                            <h3 className="text-lg font-bold text-gray-900 mb-2">{classe.name}</h3>
                            <div className="space-y-1 text-sm text-gray-600">
                              <div>📍 {classe.etablissements?.name}</div>
                              <div>📅 Saison: {classe.saisons?.name}</div>
                              <div>👤 Coach: {classe.users?.full_name}</div>
                              {classe.niveau && <div>🎓 Niveau: {classe.niveau}</div>}
                              <div className="text-xs text-gray-500 mt-2">
                                Soumise le {new Date(classe.created_at).toLocaleString('fr-FR')}
                              </div>
                            </div>
                          </div>

                          <div className="flex flex-col space-y-2 ml-4">
                            <button
                              onClick={() => validateClasse.mutate(classe.id)}
                              disabled={validateClasse.isPending}
                              className="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition disabled:opacity-50"
                            >
                              Valider
                            </button>
                            <Link
                              href={`/rame/classes/${classe.id}`}
                              className="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition text-center"
                            >
                              Voir détails
                            </Link>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                ) : (
                  <div className="text-center py-12 text-gray-500">
                    Aucune classe en attente de validation
                  </div>
                )}
              </div>
            )}
          </div>
        </div>
      </main>
    </div>
  );
}
