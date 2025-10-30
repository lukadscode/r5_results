'use client';
import { useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import { createClient } from '@/lib/supabase/client';

type SortOption = 'moyenne' | 'total_score' | 'best_time' | 'participation';

export default function PublicClassements() {
  const supabase = createClient();
  const [sortBy, setSortBy] = useState<SortOption>('moyenne');
  const [selectedLigue, setSelectedLigue] = useState<string>('');

  const { data: ligues } = useQuery({
    queryKey: ['public-ligues'],
    queryFn: async () => {
      const { data, error } = await supabase.from('ligues').select('*').order('name');
      if (error) throw error;
      return data;
    },
  });

  const { data: activeSaison } = useQuery({
    queryKey: ['public-active-saison'],
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

  const { data: classements, isLoading } = useQuery({
    queryKey: ['public-classements', activeSaison?.id, selectedLigue],
    queryFn: async () => {
      if (!activeSaison) return [];

      let query = supabase
        .from('classes')
        .select(`
          *,
          etablissements(name, ligue_id, ligues(name)),
          results(score, time_seconds)
        `)
        .eq('saison_id', activeSaison.id)
        .eq('status', 'VALIDATED');

      if (selectedLigue) {
        query = query.eq('etablissements.ligue_id', selectedLigue);
      }

      const { data, error } = await query;

      if (error) throw error;

      const classesWithStats = data.map((classe: any) => {
        const results = classe.results || [];
        const totalScore = results.reduce((sum: number, r: any) => sum + (r.score || 0), 0);
        const avgScore = results.length > 0 ? totalScore / results.length : 0;
        const bestTime = results.length > 0 ? Math.min(...results.map((r: any) => r.time_seconds || Infinity)) : 0;
        const participation = results.length;

        let moyennePonderee = 0;
        if (results.length > 0) {
          moyennePonderee = (avgScore * 0.6) + ((participation / 50) * 40);
        }

        return {
          ...classe,
          stats: {
            totalScore,
            avgScore,
            bestTime,
            participation,
            moyennePonderee,
          },
        };
      });

      classesWithStats.sort((a: any, b: any) => {
        switch (sortBy) {
          case 'moyenne':
            return b.stats.moyennePonderee - a.stats.moyennePonderee;
          case 'total_score':
            return b.stats.totalScore - a.stats.totalScore;
          case 'best_time':
            return a.stats.bestTime - b.stats.bestTime;
          case 'participation':
            return b.stats.participation - a.stats.participation;
          default:
            return 0;
        }
      });

      return classesWithStats;
    },
    enabled: !!activeSaison,
  });

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100">
      <nav className="bg-white shadow-md">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center justify-between">
            <h1 className="text-3xl font-bold text-gray-900">🚣 Classements Rame en 5e</h1>
            <a
              href="/login"
              className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
              Connexion
            </a>
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {!activeSaison ? (
          <div className="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 className="text-xl font-semibold text-gray-900 mb-2">Aucune saison active</h3>
            <p className="text-gray-600">Les classements seront disponibles lorsqu'une saison sera activée.</p>
          </div>
        ) : (
          <>
            <div className="bg-white rounded-lg shadow-md p-6 mb-6">
              <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                  <h2 className="text-2xl font-bold text-gray-900 mb-1">Saison {activeSaison.name}</h2>
                  <p className="text-gray-600 text-sm">
                    Du {new Date(activeSaison.start_date).toLocaleDateString('fr-FR')} au{' '}
                    {new Date(activeSaison.end_date).toLocaleDateString('fr-FR')}
                  </p>
                </div>

                <div className="flex flex-col sm:flex-row gap-3">
                  <select
                    value={selectedLigue}
                    onChange={(e) => setSelectedLigue(e.target.value)}
                    className="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                  >
                    <option value="">Toutes les ligues</option>
                    {ligues?.map((ligue) => (
                      <option key={ligue.id} value={ligue.id}>
                        {ligue.name}
                      </option>
                    ))}
                  </select>

                  <select
                    value={sortBy}
                    onChange={(e) => setSortBy(e.target.value as SortOption)}
                    className="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                  >
                    <option value="moyenne">Moyenne Pondérée</option>
                    <option value="total_score">Score Total</option>
                    <option value="best_time">Meilleur Temps</option>
                    <option value="participation">Participation</option>
                  </select>
                </div>
              </div>
            </div>

            {isLoading ? (
              <div className="flex justify-center items-center h-64">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
              </div>
            ) : classements && classements.length > 0 ? (
              <div className="bg-white rounded-lg shadow-md overflow-hidden">
                <div className="overflow-x-auto">
                  <table className="w-full">
                    <thead className="bg-gray-50 border-b border-gray-200">
                      <tr>
                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Rang
                        </th>
                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Classe
                        </th>
                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Établissement
                        </th>
                        <th className="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Ligue
                        </th>
                        <th className="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Moy. Pondérée
                        </th>
                        <th className="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Score Total
                        </th>
                        <th className="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                          Participation
                        </th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-200">
                      {classements.map((classe: any, index: number) => (
                        <tr
                          key={classe.id}
                          className={`hover:bg-gray-50 transition ${
                            index < 3 ? 'bg-yellow-50' : ''
                          }`}
                        >
                          <td className="px-6 py-4 whitespace-nowrap">
                            <div className="flex items-center">
                              <span
                                className={`text-2xl font-bold ${
                                  index === 0
                                    ? 'text-yellow-500'
                                    : index === 1
                                    ? 'text-gray-400'
                                    : index === 2
                                    ? 'text-amber-600'
                                    : 'text-gray-600'
                                }`}
                              >
                                {index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : index + 1}
                              </span>
                            </div>
                          </td>
                          <td className="px-6 py-4">
                            <div className="font-semibold text-gray-900">{classe.name}</div>
                            {classe.niveau && (
                              <div className="text-sm text-gray-600">{classe.niveau}</div>
                            )}
                          </td>
                          <td className="px-6 py-4 text-gray-700">{classe.etablissements?.name}</td>
                          <td className="px-6 py-4 text-gray-600 text-sm">
                            {classe.etablissements?.ligues?.name}
                          </td>
                          <td className="px-6 py-4 text-right">
                            <span className="text-lg font-bold text-blue-600">
                              {classe.stats.moyennePonderee.toFixed(1)}
                            </span>
                          </td>
                          <td className="px-6 py-4 text-right text-gray-700">
                            {classe.stats.totalScore}
                          </td>
                          <td className="px-6 py-4 text-right text-gray-700">
                            {classe.stats.participation}
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            ) : (
              <div className="bg-white rounded-lg shadow-md p-12 text-center">
                <div className="text-6xl mb-4">🏆</div>
                <h3 className="text-xl font-semibold text-gray-900 mb-2">Aucune classe validée</h3>
                <p className="text-gray-600">
                  Les classements apparaîtront dès que des classes seront validées et auront des résultats.
                </p>
              </div>
            )}
          </>
        )}

        <div className="mt-8 bg-white rounded-lg shadow-md p-6">
          <h3 className="text-lg font-bold text-gray-900 mb-3">Comment fonctionne le classement ?</h3>
          <div className="space-y-2 text-gray-700 text-sm">
            <p>
              <strong>Moyenne Pondérée</strong> : Le classement principal combine la performance (60%) et la
              participation (40%).
            </p>
            <p>
              La formule est : <code className="bg-gray-100 px-2 py-1 rounded">(Score moyen × 0.6) + (Participation/50 × 40)</code>
            </p>
            <p>Vous pouvez également trier par score total, meilleur temps ou nombre de participations.</p>
          </div>
        </div>
      </main>

      <footer className="bg-white border-t mt-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-600 text-sm">
          <p>Challenge Rame en 5e - Classement en temps réel</p>
        </div>
      </footer>
    </div>
  );
}
