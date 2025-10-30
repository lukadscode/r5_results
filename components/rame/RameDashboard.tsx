'use client';
import { useQuery } from '@tanstack/react-query';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

interface User {
  id: string;
  email: string;
  full_name: string;
  role: string;
  etablissement_id?: string;
  ligue_id?: string;
}

interface RameDashboardProps {
  user: User;
}

export default function RameDashboard({ user }: RameDashboardProps) {
  const supabase = createClient();

  const { data: activeSaison } = useQuery({
    queryKey: ['active-saison'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('saisons')
        .select('*')
        .eq('is_active', true)
        .maybeSingle();

      if (error) throw error;
      return data;
    },
  });

  const { data: myClasses, isLoading } = useQuery({
    queryKey: ['my-classes', activeSaison?.id],
    queryFn: async () => {
      if (!activeSaison) return [];

      let query = supabase
        .from('classes')
        .select('*, etablissements(name), saisons(name)')
        .eq('saison_id', activeSaison.id);

      if (user.role === 'COACH') {
        query = query.eq('etablissement_id', user.etablissement_id!);
      }

      const { data, error } = await query.order('created_at', { ascending: false });

      if (error) throw error;
      return data;
    },
    enabled: !!activeSaison,
  });

  const isAdmin = ['SUPERADMIN', 'ADMIN'].includes(user.role);
  const isAdminLigue = user.role === 'ADMIN_LIGUE';

  return (
    <div className="min-h-screen bg-gray-50">
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16 items-center">
            <div className="flex items-center space-x-4">
              <Link href="/select-module" className="text-blue-600 hover:text-blue-800 font-medium">
                ← Modules
              </Link>
              <h1 className="text-2xl font-bold text-gray-900">Rame en 5e</h1>
            </div>

            <div className="flex items-center space-x-4">
              <span className="text-sm text-gray-600">{user.full_name}</span>
              <span className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                {user.role}
              </span>

              {isAdmin && (
                <Link
                  href="/rame/admin"
                  className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                  Administration
                </Link>
              )}
            </div>
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {!activeSaison ? (
          <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <h3 className="text-lg font-semibold text-yellow-900 mb-2">Aucune saison active</h3>
            <p className="text-yellow-700 mb-4">
              Aucune saison n'est actuellement active. Contactez un administrateur pour activer une saison.
            </p>
            {isAdmin && (
              <Link
                href="/rame/admin"
                className="inline-block px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition"
              >
                Gérer les saisons
              </Link>
            )}
          </div>
        ) : (
          <>
            <div className="bg-white rounded-lg shadow-sm border p-6 mb-8">
              <div className="flex items-center justify-between">
                <div>
                  <h2 className="text-2xl font-bold text-gray-900 mb-2">
                    Saison active: {activeSaison.name}
                  </h2>
                  <p className="text-gray-600">
                    Du {new Date(activeSaison.start_date).toLocaleDateString('fr-FR')} au{' '}
                    {new Date(activeSaison.end_date).toLocaleDateString('fr-FR')}
                  </p>
                </div>

                {user.role === 'COACH' && (
                  <Link
                    href="/rame/classes/new"
                    className="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium"
                  >
                    + Nouvelle classe
                  </Link>
                )}
              </div>
            </div>

            <div className="grid md:grid-cols-3 gap-6 mb-8">
              <Link
                href="/rame/classes"
                className="bg-white rounded-xl shadow-md border-2 border-transparent hover:border-blue-500 hover:shadow-xl transition-all p-6"
              >
                <div className="text-3xl mb-3">🚣</div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">Mes Classes</h3>
                <p className="text-gray-600 text-sm mb-4">Gérer vos classes et élèves</p>
                <div className="text-2xl font-bold text-blue-600">{myClasses?.length || 0}</div>
              </Link>

              <Link
                href="/rame/results"
                className="bg-white rounded-xl shadow-md border-2 border-transparent hover:border-green-500 hover:shadow-xl transition-all p-6"
              >
                <div className="text-3xl mb-3">📊</div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">Résultats</h3>
                <p className="text-gray-600 text-sm">Consulter les performances</p>
              </Link>

              <Link
                href="/rame/stats"
                className="bg-white rounded-xl shadow-md border-2 border-transparent hover:border-purple-500 hover:shadow-xl transition-all p-6"
              >
                <div className="text-3xl mb-3">📈</div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">Statistiques</h3>
                <p className="text-gray-600 text-sm">Analyses et graphiques</p>
              </Link>
            </div>

            <div className="bg-white rounded-lg shadow-sm border p-6">
              <h3 className="text-xl font-bold text-gray-900 mb-4">Mes classes récentes</h3>

              {isLoading ? (
                <div className="flex justify-center py-8">
                  <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                </div>
              ) : (
                <>
                  {myClasses && myClasses.length > 0 ? (
                    <div className="space-y-3">
                      {myClasses.slice(0, 5).map((classe: any) => (
                        <Link
                          key={classe.id}
                          href={`/rame/classes/${classe.id}`}
                          className="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition"
                        >
                          <div>
                            <div className="font-semibold text-gray-900">{classe.name}</div>
                            <div className="text-sm text-gray-600">
                              {classe.etablissements?.name} • {classe.niveau || 'Non spécifié'}
                            </div>
                          </div>

                          <div className="flex items-center space-x-3">
                            <span
                              className={`px-3 py-1 rounded-full text-xs font-medium ${
                                classe.status === 'VALIDATED'
                                  ? 'bg-green-100 text-green-800'
                                  : classe.status === 'SUBMITTED'
                                  ? 'bg-yellow-100 text-yellow-800'
                                  : 'bg-gray-100 text-gray-800'
                              }`}
                            >
                              {classe.status === 'VALIDATED'
                                ? 'Validée'
                                : classe.status === 'SUBMITTED'
                                ? 'En attente'
                                : 'Brouillon'}
                            </span>

                            <svg
                              className="w-5 h-5 text-gray-400"
                              fill="none"
                              stroke="currentColor"
                              viewBox="0 0 24 24"
                            >
                              <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M9 5l7 7-7 7"
                              />
                            </svg>
                          </div>
                        </Link>
                      ))}
                    </div>
                  ) : (
                    <div className="text-center py-8 text-gray-500">
                      <p>Aucune classe pour cette saison</p>
                      {user.role === 'COACH' && (
                        <Link
                          href="/rame/classes/new"
                          className="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium"
                        >
                          Créer votre première classe
                        </Link>
                      )}
                    </div>
                  )}
                </>
              )}
            </div>
          </>
        )}
      </main>
    </div>
  );
}
