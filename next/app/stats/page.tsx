import Nav from '@/components/Nav';
import StatsView from '@/components/StatsView';

export default function StatsPage() {
  return (
    <>
      <Nav />
      <main style={{ padding: 24 }}>
        <h1>Statistiques</h1>
        <StatsView />
      </main>
    </>
  );
}


