import { getCurrentUser } from '@/lib/auth';
import Nav from '@/components/Nav';
import ClassesView from '@/components/ClassesView';

export default async function ClassesPage() {
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
        <h1>Classes</h1>
        <ClassesView />
      </main>
    </>
  );
}


