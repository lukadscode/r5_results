import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import RameDashboard from '@/components/rame/RameDashboard';

export const dynamic = 'force-dynamic';


export default async function RameDashboardPage() {
  const user = await getCurrentUser();

  if (!user) {
    redirect('/login');
  }

  return <RameDashboard user={user} />;
}
