import { getCurrentUser } from '@/lib/auth';
import { redirect } from 'next/navigation';
import ThemeView from '@/components/padlet/ThemeView';

export default async function ThemePage({ params }: { params: { id: string } }) {
  const user = await getCurrentUser();
  if (!user) redirect('/login');
  return <ThemeView themeId={params.id} />;
}
