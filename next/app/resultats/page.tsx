import { getCurrentUser } from '@/lib/auth';
import Nav from '@/components/Nav';
import ResultatsView from '@/components/ResultatsView';

export default async function ResultatsPage() {
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
        <h1>Résultats</h1>
        <ResultatsView />
      </main>
    </>
  );
}


