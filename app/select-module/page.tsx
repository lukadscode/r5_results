import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import ModuleSelector from '@/components/ModuleSelector';

export default async function SelectModulePage() {
  const user = await getCurrentUser();

  if (!user) {
    redirect('/login');
  }

  return (
    <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-12">
          <h1 className="text-4xl font-bold text-gray-900 mb-3">
            Bienvenue, {user.full_name}
          </h1>
          <p className="text-xl text-gray-600">
            Sélectionnez le module que vous souhaitez utiliser
          </p>
        </div>

        <ModuleSelector userRole={user.role} />
      </div>
    </main>
  );
}
