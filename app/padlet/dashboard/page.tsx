import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import PadletDashboard from '@/components/padlet/PadletDashboard';

export const dynamic = 'force-dynamic';


export default async function PadletDashboardPage() {
  const user = await getCurrentUser();
  if (!user) redirect('/login');
  return <PadletDashboard user={user} />;
}
