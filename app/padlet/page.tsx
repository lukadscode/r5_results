import { getCurrentUser } from '@/lib/auth';
import Nav from '@/components/Nav';
import PadletView from '@/components/PadletView';

export default async function PadletPage() {
  const user = await getCurrentUser();
  if (!user) {
    return (
      <main style={{ padding: 24 }}>
        <h1>Accès restreint</h1>
      </main>
    );
  }
  return (
    <>
      <Nav />
      <main style={{ padding: 24 }}>
        <h1>Padlet</h1>
        <PadletView />
      </main>
    </>
  );
}


