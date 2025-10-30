'use client';
import Link from 'next/link';

interface ModuleSelectorProps {
  userRole: string;
}

export default function ModuleSelector({ userRole }: ModuleSelectorProps) {
  const isAdmin = ['SUPERADMIN', 'ADMIN'].includes(userRole);

  return (
    <>
      <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-8">
      <Link href="/padlet/dashboard" className="group">
        <div className="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-500">
          <div className="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
            <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
          </div>

          <h2 className="text-2xl font-bold text-gray-900 mb-3">Padlet</h2>
          <p className="text-gray-600 mb-4">
            Gestion des contenus pédagogiques, thèmes, sous-thèmes et ressources multimédias.
          </p>

          <div className="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition-transform">
            Accéder au module
            <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </div>
        </div>
      </Link>

      <Link href="/rame/dashboard" className="group">
        <div className="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-green-500">
          <div className="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
            <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>

          <h2 className="text-2xl font-bold text-gray-900 mb-3">Rame en 5e</h2>
          <p className="text-gray-600 mb-4">
            Gestion des classes, élèves, résultats et statistiques pour le challenge d'aviron.
          </p>

          <div className="flex items-center text-green-600 font-semibold group-hover:translate-x-2 transition-transform">
            Accéder au module
            <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </div>
        </div>
      </Link>
      </div>

      {isAdmin && (
        <div className="max-w-4xl mx-auto">
          <h3 className="text-xl font-bold text-gray-900 mb-4">Administration</h3>
          <div className="grid md:grid-cols-3 gap-4">
            <Link href="/admin/users" className="group">
              <div className="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-md p-6 hover:shadow-lg transition-all transform hover:scale-105">
                <div className="flex items-center space-x-3">
                  <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                  </svg>
                  <span className="text-white font-semibold">Utilisateurs</span>
                </div>
              </div>
            </Link>

            <Link href="/rame/admin" className="group">
              <div className="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl shadow-md p-6 hover:shadow-lg transition-all transform hover:scale-105">
                <div className="flex items-center space-x-3">
                  <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clipRule="evenodd" />
                  </svg>
                  <span className="text-white font-semibold">Rame Admin</span>
                </div>
              </div>
            </Link>

            <Link href="/padlet/admin" className="group">
              <div className="bg-gradient-to-br from-pink-500 to-pink-700 rounded-xl shadow-md p-6 hover:shadow-lg transition-all transform hover:scale-105">
                <div className="flex items-center space-x-3">
                  <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clipRule="evenodd" />
                  </svg>
                  <span className="text-white font-semibold">Padlet Admin</span>
                </div>
              </div>
            </Link>
          </div>
        </div>
      )}
    </>
  );
}
