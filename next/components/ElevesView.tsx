'use client';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useState } from 'react';

export default function ElevesView() {
  const qc = useQueryClient();
  const { data, isLoading } = useQuery({
    queryKey: ['eleves'],
    queryFn: async () => {
      const res = await fetch('/api/eleves');
      if (!res.ok) throw new Error('load');
      return res.json() as Promise<{ items: Array<{ id: string; firstName: string; lastName: string; classeId: string }> }>;
    }
  });

  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [classeId, setClasseId] = useState('');
  const create = useMutation({
    mutationFn: async () => {
      const res = await fetch('/api/eleves', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ firstName, lastName, classeId }) });
      if (!res.ok) throw new Error('create');
      return res.json();
    },
    onSuccess: () => {
      setFirstName('');
      setLastName('');
      setClasseId('');
      qc.invalidateQueries({ queryKey: ['eleves'] });
    }
  });

  return (
    <div>
      <h2>Liste des élèves</h2>
      {isLoading ? <div>Chargement...</div> : (
        <ul>
          {data?.items?.map((e) => (
            <li key={e.id}>{e.lastName} {e.firstName}</li>
          ))}
        </ul>
      )}

      <h3>Ajouter un élève</h3>
      <div style={{ display: 'grid', gap: 8, maxWidth: 400 }}>
        <input placeholder="Nom" value={lastName} onChange={(e) => setLastName(e.target.value)} />
        <input placeholder="Prénom" value={firstName} onChange={(e) => setFirstName(e.target.value)} />
        <input placeholder="Classe ID" value={classeId} onChange={(e) => setClasseId(e.target.value)} />
        <button onClick={() => create.mutate()} disabled={!firstName || !lastName || !classeId}>Créer</button>
      </div>
    </div>
  );
}


