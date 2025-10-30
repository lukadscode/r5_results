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

interface PadletAdminProps {
  user: User;
}

export default function PadletAdmin({ user }: PadletAdminProps) {
  const supabase = createClient();
  const qc = useQueryClient();

  const [activeTab, setActiveTab] = useState<'themes' | 'subthemes' | 'content'>('themes');

  const [themeForm, setThemeForm] = useState({ title: '', description: '', icon: '', color: '#3B82F6' });
  const [subthemeForm, setSubthemeForm] = useState({ theme_id: '', title: '', description: '' });
  const [contentForm, setContentForm] = useState({
    subtheme_id: '',
    title: '',
    content_type: 'TEXT' as 'TEXT' | 'DOCUMENT' | 'IMAGE' | 'VIDEO_YOUTUBE',
    text_content: '',
    document_url: '',
    image_url: '',
    video_youtube_id: '',
  });

  const { data: themes } = useQuery({
    queryKey: ['admin-themes'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_themes')
        .select('*')
        .order('display_order');
      if (error) throw error;
      return data;
    },
  });

  const { data: subthemes } = useQuery({
    queryKey: ['admin-subthemes'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_subthemes')
        .select('*, padlet_themes(title)')
        .order('theme_id')
        .order('display_order');
      if (error) throw error;
      return data;
    },
  });

  const { data: contents } = useQuery({
    queryKey: ['admin-contents'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_content')
        .select('*, padlet_subthemes(title)')
        .order('subtheme_id')
        .order('display_order');
      if (error) throw error;
      return data;
    },
  });

  const createTheme = useMutation({
    mutationFn: async () => {
      const { error } = await supabase.from('padlet_themes').insert({
        ...themeForm,
        created_by: user.id,
      });
      if (error) throw error;
    },
    onSuccess: () => {
      setThemeForm({ title: '', description: '', icon: '', color: '#3B82F6' });
      qc.invalidateQueries({ queryKey: ['admin-themes'] });
      qc.invalidateQueries({ queryKey: ['padlet-themes'] });
    },
  });

  const createSubtheme = useMutation({
    mutationFn: async () => {
      const { error } = await supabase.from('padlet_subthemes').insert(subthemeForm);
      if (error) throw error;
    },
    onSuccess: () => {
      setSubthemeForm({ theme_id: '', title: '', description: '' });
      qc.invalidateQueries({ queryKey: ['admin-subthemes'] });
    },
  });

  const createContent = useMutation({
    mutationFn: async () => {
      const { error } = await supabase.from('padlet_content').insert({
        ...contentForm,
        created_by: user.id,
      });
      if (error) throw error;
    },
    onSuccess: () => {
      setContentForm({
        subtheme_id: '',
        title: '',
        content_type: 'TEXT',
        text_content: '',
        document_url: '',
        image_url: '',
        video_youtube_id: '',
      });
      qc.invalidateQueries({ queryKey: ['admin-contents'] });
    },
  });

  const toggleContentPublish = useMutation({
    mutationFn: async ({ id, is_published }: { id: string; is_published: boolean }) => {
      const { error } = await supabase
        .from('padlet_content')
        .update({ is_published: !is_published })
        .eq('id', id);
      if (error) throw error;
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: ['admin-contents'] });
    },
  });

  return (
    <div className="min-h-screen bg-gray-50">
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16 items-center">
            <div className="flex items-center space-x-4">
              <Link href="/padlet/dashboard" className="text-blue-600 hover:text-blue-800 font-medium">
                ← Retour au Padlet
              </Link>
              <h1 className="text-2xl font-bold text-gray-900">Administration Padlet</h1>
            </div>
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="bg-white rounded-lg shadow-sm border mb-6">
          <div className="flex border-b">
            <button
              onClick={() => setActiveTab('themes')}
              className={`px-6 py-4 font-medium transition ${
                activeTab === 'themes'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Thèmes
            </button>
            <button
              onClick={() => setActiveTab('subthemes')}
              className={`px-6 py-4 font-medium transition ${
                activeTab === 'subthemes'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Sous-thèmes
            </button>
            <button
              onClick={() => setActiveTab('content')}
              className={`px-6 py-4 font-medium transition ${
                activeTab === 'content'
                  ? 'border-b-2 border-blue-600 text-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Contenus
            </button>
          </div>

          <div className="p-6">
            {activeTab === 'themes' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Créer un thème</h2>
                <div className="grid md:grid-cols-2 gap-4 mb-8">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input
                      type="text"
                      value={themeForm.title}
                      onChange={(e) => setThemeForm({ ...themeForm, title: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Ex: Techniques d'aviron"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Icône (emoji)</label>
                    <input
                      type="text"
                      value={themeForm.icon}
                      onChange={(e) => setThemeForm({ ...themeForm, icon: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="🚣"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                    <input
                      type="color"
                      value={themeForm.color}
                      onChange={(e) => setThemeForm({ ...themeForm, color: e.target.value })}
                      className="w-full h-10 px-2 border rounded-lg"
                    />
                  </div>

                  <div className="md:col-span-2">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea
                      value={themeForm.description}
                      onChange={(e) => setThemeForm({ ...themeForm, description: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      rows={3}
                      placeholder="Description du thème..."
                    />
                  </div>

                  <button
                    onClick={() => createTheme.mutate()}
                    disabled={!themeForm.title || createTheme.isPending}
                    className="md:col-span-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    {createTheme.isPending ? 'Création...' : 'Créer le thème'}
                  </button>
                </div>

                <h3 className="text-lg font-bold mb-4">Thèmes existants</h3>
                <div className="space-y-2">
                  {themes?.map((theme) => (
                    <div key={theme.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                      <div className="flex items-center space-x-3">
                        <div
                          className="w-10 h-10 rounded-lg flex items-center justify-center"
                          style={{ backgroundColor: theme.color }}
                        >
                          {theme.icon || '📚'}
                        </div>
                        <div>
                          <div className="font-medium">{theme.title}</div>
                          <div className="text-sm text-gray-600">{theme.description}</div>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {activeTab === 'subthemes' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Créer un sous-thème</h2>
                <div className="grid md:grid-cols-2 gap-4 mb-8">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Thème parent *</label>
                    <select
                      value={subthemeForm.theme_id}
                      onChange={(e) => setSubthemeForm({ ...subthemeForm, theme_id: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                      <option value="">Sélectionner un thème</option>
                      {themes?.map((theme) => (
                        <option key={theme.id} value={theme.id}>
                          {theme.icon} {theme.title}
                        </option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input
                      type="text"
                      value={subthemeForm.title}
                      onChange={(e) => setSubthemeForm({ ...subthemeForm, title: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Ex: Les différentes prises"
                    />
                  </div>

                  <div className="md:col-span-2">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea
                      value={subthemeForm.description}
                      onChange={(e) => setSubthemeForm({ ...subthemeForm, description: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      rows={3}
                    />
                  </div>

                  <button
                    onClick={() => createSubtheme.mutate()}
                    disabled={!subthemeForm.theme_id || !subthemeForm.title || createSubtheme.isPending}
                    className="md:col-span-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    {createSubtheme.isPending ? 'Création...' : 'Créer le sous-thème'}
                  </button>
                </div>

                <h3 className="text-lg font-bold mb-4">Sous-thèmes existants</h3>
                <div className="space-y-2">
                  {subthemes?.map((subtheme: any) => (
                    <div key={subtheme.id} className="p-4 bg-gray-50 rounded-lg">
                      <div className="font-medium">{subtheme.title}</div>
                      <div className="text-sm text-gray-600">Thème: {subtheme.padlet_themes?.title}</div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {activeTab === 'content' && (
              <div>
                <h2 className="text-xl font-bold mb-4">Créer un contenu</h2>
                <div className="grid md:grid-cols-2 gap-4 mb-8">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Sous-thème *</label>
                    <select
                      value={contentForm.subtheme_id}
                      onChange={(e) => setContentForm({ ...contentForm, subtheme_id: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                      <option value="">Sélectionner un sous-thème</option>
                      {subthemes?.map((subtheme: any) => (
                        <option key={subtheme.id} value={subtheme.id}>
                          {subtheme.title}
                        </option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input
                      type="text"
                      value={contentForm.title}
                      onChange={(e) => setContentForm({ ...contentForm, title: e.target.value })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Titre du contenu"
                    />
                  </div>

                  <div className="md:col-span-2">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Type de contenu *</label>
                    <select
                      value={contentForm.content_type}
                      onChange={(e) => setContentForm({ ...contentForm, content_type: e.target.value as any })}
                      className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                      <option value="TEXT">Texte</option>
                      <option value="DOCUMENT">Document (PDF, etc.)</option>
                      <option value="IMAGE">Image</option>
                      <option value="VIDEO_YOUTUBE">Vidéo YouTube</option>
                    </select>
                  </div>

                  {contentForm.content_type === 'TEXT' && (
                    <div className="md:col-span-2">
                      <label className="block text-sm font-medium text-gray-700 mb-2">Contenu texte</label>
                      <textarea
                        value={contentForm.text_content}
                        onChange={(e) => setContentForm({ ...contentForm, text_content: e.target.value })}
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        rows={6}
                      />
                    </div>
                  )}

                  {contentForm.content_type === 'DOCUMENT' && (
                    <div className="md:col-span-2">
                      <label className="block text-sm font-medium text-gray-700 mb-2">URL du document</label>
                      <input
                        type="url"
                        value={contentForm.document_url}
                        onChange={(e) => setContentForm({ ...contentForm, document_url: e.target.value })}
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="https://..."
                      />
                    </div>
                  )}

                  {contentForm.content_type === 'IMAGE' && (
                    <div className="md:col-span-2">
                      <label className="block text-sm font-medium text-gray-700 mb-2">URL de l'image</label>
                      <input
                        type="url"
                        value={contentForm.image_url}
                        onChange={(e) => setContentForm({ ...contentForm, image_url: e.target.value })}
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="https://..."
                      />
                    </div>
                  )}

                  {contentForm.content_type === 'VIDEO_YOUTUBE' && (
                    <div className="md:col-span-2">
                      <label className="block text-sm font-medium text-gray-700 mb-2">ID vidéo YouTube</label>
                      <input
                        type="text"
                        value={contentForm.video_youtube_id}
                        onChange={(e) => setContentForm({ ...contentForm, video_youtube_id: e.target.value })}
                        className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Ex: dQw4w9WgXcQ"
                      />
                      <p className="text-xs text-gray-500 mt-1">
                        L'ID se trouve dans l'URL: youtube.com/watch?v=<strong>dQw4w9WgXcQ</strong>
                      </p>
                    </div>
                  )}

                  <button
                    onClick={() => createContent.mutate()}
                    disabled={!contentForm.subtheme_id || !contentForm.title || createContent.isPending}
                    className="md:col-span-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    {createContent.isPending ? 'Création...' : 'Créer le contenu'}
                  </button>
                </div>

                <h3 className="text-lg font-bold mb-4">Contenus existants</h3>
                <div className="space-y-2">
                  {contents?.map((content: any) => (
                    <div key={content.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                      <div>
                        <div className="font-medium">{content.title}</div>
                        <div className="text-sm text-gray-600">
                          Type: {content.content_type} • Sous-thème: {content.padlet_subthemes?.title}
                        </div>
                      </div>
                      <button
                        onClick={() => toggleContentPublish.mutate({ id: content.id, is_published: content.is_published })}
                        className={`px-4 py-2 rounded-lg font-medium transition ${
                          content.is_published
                            ? 'bg-green-100 text-green-700 hover:bg-green-200'
                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        }`}
                      >
                        {content.is_published ? 'Publié' : 'Brouillon'}
                      </button>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>
        </div>
      </main>
    </div>
  );
}
