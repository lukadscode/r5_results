import { cookies } from 'next/headers';
import Nav from '@/components/Nav';

export default async function DashboardPage() {
  const cookieStore = await cookies();
  const isAuth = Boolean(cookieStore.get('r5_session'));
  if (!isAuth) {
    return (
      <main style={{ padding: 24 }}>
        <h1>Non connecté</h1>
        <a href="/login">Aller à la connexion</a>
      </main>
    );
  }
  return (
    <>
      <Nav />
      <main style={{ padding: 24 }}>
        <h1>Tableau de bord</h1>
        <p>Bienvenue !</p>
      </main>
    </>
  );
}


