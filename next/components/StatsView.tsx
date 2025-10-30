'use client';
import { useQuery } from '@tanstack/react-query';

export default function StatsView() {
  const { data, isLoading } = useQuery({
    queryKey: ['stats'],
    queryFn: async () => {
      const r = await fetch('/api/stats');
      if (!r.ok) throw new Error('stats');
      return r.json() as Promise<{ total: number; averageScore: number; bestScore: number; worstScore: number }>;
    }
  });
  return (
    <section>
      {isLoading ? 'Chargement...' : (
        <ul>
          <li>Total résultats: {data?.total}</li>
          <li>Score moyen: {data?.averageScore}</li>
          <li>Meilleur score: {data?.bestScore}</li>
          <li>Pire score: {data?.worstScore}</li>
        </ul>
      )}
    </section>
  );
}


