'use client';
import { useQuery } from '@tanstack/react-query';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

interface User {
  id: string;
  email: string;
  full_name: string;
  role: string;
}

interface PadletDashboardProps {
  user: User;
}

export default function PadletDashboard({ user }: PadletDashboardProps) {
  const supabase = createClient();

  const { data: themes, isLoading } = useQuery({
    queryKey: ['padlet-themes'],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_themes')
        .select('*')
        .eq('is_visible', true)
        .order('display_order', { ascending: true });

      if (error) throw error;
      return data;
    },
  });

  const isAdmin = ['SUPERADMIN', 'ADMIN'].includes(user.role);

  return (
    <div className="min-h-screen bg-gray-50">
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16 items-center">
            <div className="flex items-center space-x-4">
              <Link href="/select-module" className="text-blue-600 hover:text-blue-800 font-medium">
                ← Modules
              </Link>
              <h1 className="text-2xl font-bold text-gray-900">Padlet</h1>
            </div>
            <div className="flex items-center space-x-4">
              <span className="text-sm text-gray-600">{user.full_name}</span>
              {isAdmin && (
                <Link
                  href="/padlet/admin"
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
        <div className="mb-8">
          <h2 className="text-3xl font-bold text-gray-900 mb-2">Ressources Pédagogiques</h2>
          <p className="text-gray-600">Explorez les contenus par thème</p>
        </div>

        {isLoading ? (
          <div className="flex justify-center items-center h-64">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          </div>
        ) : (
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {themes?.map((theme) => (
              <Link
                key={theme.id}
                href={`/padlet/theme/${theme.id}`}
                className="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-2 border-transparent hover:border-blue-500"
              >
                <div
                  className="w-12 h-12 rounded-lg mb-4 flex items-center justify-center text-2xl"
                  style={{ backgroundColor: theme.color || '#3B82F6' }}
                >
                  {theme.icon || '📚'}
                </div>

                <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition">
                  {theme.title}
                </h3>

                {theme.description && (
                  <p className="text-gray-600 text-sm line-clamp-2">{theme.description}</p>
                )}

                <div className="mt-4 flex items-center text-blue-600 font-medium text-sm group-hover:translate-x-1 transition-transform">
                  Explorer
                  <svg className="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                  </svg>
                </div>
              </Link>
            ))}

            {(!themes || themes.length === 0) && (
              <div className="col-span-full text-center py-12">
                <p className="text-gray-500 mb-4">Aucun thème disponible pour le moment</p>
                {isAdmin && (
                  <Link
                    href="/padlet/admin"
                    className="text-blue-600 hover:text-blue-800 font-medium"
                  >
                    Créer un premier thème
                  </Link>
                )}
              </div>
            )}
          </div>
        )}
      </main>
    </div>
  );
}
