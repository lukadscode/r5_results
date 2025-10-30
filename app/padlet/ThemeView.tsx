'use client';
import { useQuery } from '@tanstack/react-query';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

interface ThemeViewProps {
  themeId: string;
}

export default function ThemeView({ themeId }: ThemeViewProps) {
  const supabase = createClient();

  const { data: theme } = useQuery({
    queryKey: ['theme', themeId],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_themes')
        .select('*')
        .eq('id', themeId)
        .maybeSingle();

      if (error) throw error;
      return data;
    },
  });

  const { data: subthemes, isLoading } = useQuery({
    queryKey: ['subthemes', themeId],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_subthemes')
        .select('*')
        .eq('theme_id', themeId)
        .eq('is_visible', true)
        .order('display_order');

      if (error) throw error;
      return data;
    },
  });

  return (
    <div className="min-h-screen bg-gray-50">
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center h-16 space-x-4">
            <Link href="/padlet/dashboard" className="text-blue-600 hover:text-blue-800 font-medium">
              ← Retour
            </Link>
            {theme && (
              <div className="flex items-center space-x-3">
                <div
                  className="w-10 h-10 rounded-lg flex items-center justify-center"
                  style={{ backgroundColor: theme.color }}
                >
                  {theme.icon || '📚'}
                </div>
                <h1 className="text-2xl font-bold text-gray-900">{theme.title}</h1>
              </div>
            )}
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {theme?.description && (
          <div className="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <p className="text-gray-700">{theme.description}</p>
          </div>
        )}

        <h2 className="text-2xl font-bold text-gray-900 mb-6">Sous-thèmes</h2>

        {isLoading ? (
          <div className="flex justify-center items-center h-64">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          </div>
        ) : (
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {subthemes?.map((subtheme) => (
              <Link
                key={subtheme.id}
                href={`/padlet/subtheme/${subtheme.id}`}
                className="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-2 border-transparent hover:border-blue-500"
              >
                <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition">
                  {subtheme.title}
                </h3>

                {subtheme.description && (
                  <p className="text-gray-600 text-sm line-clamp-3 mb-4">{subtheme.description}</p>
                )}

                <div className="flex items-center text-blue-600 font-medium text-sm group-hover:translate-x-1 transition-transform">
                  Voir les contenus
                  <svg className="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                  </svg>
                </div>
              </Link>
            ))}

            {(!subthemes || subthemes.length === 0) && (
              <div className="col-span-full text-center py-12 text-gray-500">
                Aucun sous-thème disponible pour ce thème
              </div>
            )}
          </div>
        )}
      </main>
    </div>
  );
}
