import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import SubthemeView from '@/components/padlet/SubthemeView';

export const dynamic = 'force-dynamic';

export default async function SubthemePage({ params }: { params: { id: string } }) {
  const user = await getCurrentUser();
  if (!user) redirect('/login');
  return <SubthemeView subthemeId={params.id} />;
}
