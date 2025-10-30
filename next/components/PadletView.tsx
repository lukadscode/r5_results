'use client';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useState } from 'react';

export default function PadletView() {
  const qc = useQueryClient();
  const cats = useQuery({
    queryKey: ['padlet', 'categories'],
    queryFn: async () => {
      const r = await fetch('/api/padlet/categories');
      if (!r.ok) throw new Error('cats');
      return r.json() as Promise<{ items: Array<{ id: string; name: string }> }>;
    }
  });
  const arts = useQuery({
    queryKey: ['padlet', 'articles'],
    queryFn: async () => {
      const r = await fetch('/api/padlet/articles');
      if (!r.ok) throw new Error('arts');
      return r.json() as Promise<{ items: Array<{ id: string; title: string; content: string; categoryId: string }> }>;
    }
  });

  const [catName, setCatName] = useState('');
  const newCat = useMutation({
    mutationFn: async () => {
      const r = await fetch('/api/padlet/categories', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ name: catName }) });
      if (!r.ok) throw new Error('newcat');
      return r.json();
    },
    onSuccess: () => {
      setCatName('');
      qc.invalidateQueries({ queryKey: ['padlet', 'categories'] });
    }
  });

  const [title, setTitle] = useState('');
  const [content, setContent] = useState('');
  const [categoryId, setCategoryId] = useState('');
  const newArt = useMutation({
    mutationFn: async () => {
      const r = await fetch('/api/padlet/articles', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ title, content, categoryId, createdBy: 'system' }) });
      if (!r.ok) throw new Error('newart');
      return r.json();
    },
    onSuccess: () => {
      setTitle('');
      setContent('');
      setCategoryId('');
      qc.invalidateQueries({ queryKey: ['padlet', 'articles'] });
    }
  });

  return (
    <div style={{ display: 'grid', gap: 24 }}>
      <section>
        <h2>Catégories</h2>
        {cats.isLoading ? 'Chargement...' : (
          <ul>
            {cats.data?.items?.map((c) => (<li key={c.id}>{c.name}</li>))}
          </ul>
        )}
        <div style={{ display: 'flex', gap: 8 }}>
          <input placeholder="Nom de la catégorie" value={catName} onChange={(e) => setCatName(e.target.value)} />
          <button onClick={() => newCat.mutate()} disabled={!catName}>Ajouter</button>
        </div>
      </section>

      <section>
        <h2>Articles</h2>
        {arts.isLoading ? 'Chargement...' : (
          <ul>
            {arts.data?.items?.map((a) => (<li key={a.id}>{a.title}</li>))}
          </ul>
        )}
        <div style={{ display: 'grid', gap: 8, maxWidth: 520 }}>
          <input placeholder="Titre" value={title} onChange={(e) => setTitle(e.target.value)} />
          <textarea placeholder="Contenu" value={content} onChange={(e) => setContent(e.target.value)} />
          <input placeholder="Category ID" value={categoryId} onChange={(e) => setCategoryId(e.target.value)} />
          <button onClick={() => newArt.mutate()} disabled={!title || !content || !categoryId}>Publier</button>
        </div>
      </section>
    </div>
  );
}


