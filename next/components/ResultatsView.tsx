'use client';
import { useQuery } from '@tanstack/react-query';

export default function ResultatsView() {
  const { data, isLoading } = useQuery({
    queryKey: ['resultats'],
    queryFn: async () => {
      const res = await fetch('/api/resultats');
      if (!res.ok) throw new Error('load');
      return res.json() as Promise<{ items: Array<{ id: string; score: number; timeSeconds: number; eleveId: string; gameId: string }> }>;
    }
  });
  return (
    <div>
      <h2>Derniers résultats</h2>
      {isLoading ? 'Chargement...' : (
        <table>
          <thead>
            <tr>
              <th>Élève</th>
              <th>Score</th>
              <th>Temps (s)</th>
              <th>Jeu</th>
            </tr>
          </thead>
          <tbody>
            {data?.items?.map((r) => (
              <tr key={r.id}>
                <td>{r.eleveId}</td>
                <td>{r.score}</td>
                <td>{r.timeSeconds}</td>
                <td>{r.gameId}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}


