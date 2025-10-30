'use client';
import { useQuery } from '@tanstack/react-query';
import Link from 'next/link';
import { createClient } from '@/lib/supabase/client';

interface SubthemeViewProps {
  subthemeId: string;
}

export default function SubthemeView({ subthemeId }: SubthemeViewProps) {
  const supabase = createClient();

  const { data: subtheme } = useQuery({
    queryKey: ['subtheme', subthemeId],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_subthemes')
        .select('*, padlet_themes(*)')
        .eq('id', subthemeId)
        .maybeSingle();

      if (error) throw error;
      return data;
    },
  });

  const { data: contents, isLoading } = useQuery({
    queryKey: ['contents', subthemeId],
    queryFn: async () => {
      const { data, error } = await supabase
        .from('padlet_content')
        .select('*')
        .eq('subtheme_id', subthemeId)
        .eq('is_published', true)
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
            {subtheme?.padlet_themes && (
              <Link
                href={`/padlet/theme/${subtheme.padlet_themes.id}`}
                className="text-blue-600 hover:text-blue-800 font-medium"
              >
                ← {subtheme.padlet_themes.title}
              </Link>
            )}
            <h1 className="text-2xl font-bold text-gray-900">{subtheme?.title}</h1>
          </div>
        </div>
      </nav>

      <main className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {subtheme?.description && (
          <div className="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <p className="text-gray-700">{subtheme.description}</p>
          </div>
        )}

        {isLoading ? (
          <div className="flex justify-center items-center h-64">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          </div>
        ) : (
          <div className="space-y-6">
            {contents?.map((content) => (
              <div key={content.id} className="bg-white rounded-xl shadow-md border p-6">
                <h3 className="text-xl font-bold text-gray-900 mb-4">{content.title}</h3>

                {content.content_type === 'TEXT' && content.text_content && (
                  <div className="prose max-w-none">
                    <p className="whitespace-pre-wrap text-gray-700">{content.text_content}</p>
                  </div>
                )}

                {content.content_type === 'DOCUMENT' && content.document_url && (
                  <div>
                    <a
                      href={content.document_url}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                      <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                          strokeLinecap="round"
                          strokeLinejoin="round"
                          strokeWidth={2}
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>
                      Télécharger le document
                    </a>
                  </div>
                )}

                {content.content_type === 'IMAGE' && content.image_url && (
                  <div className="rounded-lg overflow-hidden">
                    <img
                      src={content.image_url}
                      alt={content.title}
                      className="w-full h-auto"
                    />
                  </div>
                )}

                {content.content_type === 'VIDEO_YOUTUBE' && content.video_youtube_id && (
                  <div className="aspect-video">
                    <iframe
                      width="100%"
                      height="100%"
                      src={`https://www.youtube.com/embed/${content.video_youtube_id}`}
                      title={content.title}
                      frameBorder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowFullScreen
                      className="rounded-lg"
                    />
                  </div>
                )}
              </div>
            ))}

            {(!contents || contents.length === 0) && (
              <div className="text-center py-12 text-gray-500">
                Aucun contenu publié pour ce sous-thème
              </div>
            )}
          </div>
        )}
      </main>
    </div>
  );
}
