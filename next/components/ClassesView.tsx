'use client';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useState } from 'react';

export default function ClassesView() {
  const qc = useQueryClient();
  const { data, isLoading } = useQuery({
    queryKey: ['classes'],
    queryFn: async () => {
      const res = await fetch('/api/classes');
      if (!res.ok) throw new Error('load');
      return res.json() as Promise<{ items: Array<{ id: string; name: string; etablissementId: string }> }>;
    }
  });

  const [name, setName] = useState('');
  const [etab, setEtab] = useState('');
  const create = useMutation({
    mutationFn: async () => {
      const res = await fetch('/api/classes', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ name, etablissementId: etab }) });
      if (!res.ok) throw new Error('create');
      return res.json();
    },
    onSuccess: () => {
      setName('');
      setEtab('');
      qc.invalidateQueries({ queryKey: ['classes'] });
    }
  });

  return (
    <div>
      <h2>Liste des classes</h2>
      {isLoading ? <div>Chargement...</div> : (
        <ul>
          {data?.items?.map((c) => (
            <li key={c.id}>{c.name}</li>
          ))}
        </ul>
      )}

      <h3>Ajouter une classe</h3>
      <div style={{ display: 'grid', gap: 8, maxWidth: 400 }}>
        <input placeholder="Nom" value={name} onChange={(e) => setName(e.target.value)} />
        <input placeholder="Etablissement ID" value={etab} onChange={(e) => setEtab(e.target.value)} />
        <button onClick={() => create.mutate()} disabled={!name || !etab}>Créer</button>
      </div>
    </div>
  );
}


