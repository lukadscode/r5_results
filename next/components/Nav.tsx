'use client';
import Link from 'next/link';
import { useRouter } from 'next/navigation';

export default function Nav() {
  const router = useRouter();
  const logout = async () => {
    await fetch('/api/auth/logout', { method: 'POST' });
    router.push('/login');
  };
  const linkStyle: React.CSSProperties = { marginRight: 12 };
  return (
    <nav style={{ display: 'flex', gap: 12, padding: 12, borderBottom: '1px solid #ddd' }}>
      <Link href="/dashboard" style={linkStyle}>Dashboard</Link>
      <Link href="/classes" style={linkStyle}>Classes</Link>
      <Link href="/eleves" style={linkStyle}>Élèves</Link>
      <Link href="/padlet" style={linkStyle}>Padlet</Link>
      <Link href="/resultats" style={linkStyle}>Résultats</Link>
      <Link href="/imports" style={linkStyle}>Imports</Link>
      <Link href="/stats" style={linkStyle}>Stats</Link>
      <div style={{ flex: 1 }} />
      <button onClick={logout}>Déconnexion</button>
    </nav>
  );
}


