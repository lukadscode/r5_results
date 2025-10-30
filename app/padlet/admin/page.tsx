import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import PadletAdmin from '@/components/padlet/PadletAdmin';

export default async function PadletAdminPage() {
  const user = await getCurrentUser();
  if (!user || !['SUPERADMIN', 'ADMIN'].includes(user.role)) redirect('/padlet/dashboard');
  return <PadletAdmin user={user} />;
}
