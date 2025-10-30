import { getCurrentUser } from '@/lib/auth';
import Nav from '@/components/Nav';
import ElevesView from '@/components/ElevesView';

export default async function ElevesPage() {
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
        <h1>Élèves</h1>
        <ElevesView />
      </main>
    </>
  );
}


