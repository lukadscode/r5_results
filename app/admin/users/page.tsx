import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import UsersManagement from '@/components/admin/UsersManagement';

export const dynamic = 'force-dynamic';

export default async function UsersManagementPage() {
  const user = await getCurrentUser();

  if (!user || !['SUPERADMIN', 'ADMIN'].includes(user.role)) {
    redirect('/select-module');
  }

  return <UsersManagement currentUser={user} />;
}
