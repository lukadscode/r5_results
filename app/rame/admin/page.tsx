import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import RameAdmin from '@/components/rame/RameAdmin';

export default async function RameAdminPage() {
  const user = await getCurrentUser();

  if (!user || !['SUPERADMIN', 'ADMIN'].includes(user.role)) {
    redirect('/rame/dashboard');
  }

  return <RameAdmin user={user} />;
}
