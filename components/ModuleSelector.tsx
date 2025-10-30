'use client';
import Link from 'next/link';

interface ModuleSelectorProps {
  userRole: string;
}

export default function ModuleSelector({ userRole }: ModuleSelectorProps) {
  return (
    <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
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
  );
}
