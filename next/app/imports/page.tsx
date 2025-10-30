import Nav from '@/components/Nav';

export default function ImportsPage() {
  return (
    <>
      <Nav />
      <main style={{ padding: 24 }}>
        <h1>Import Excel</h1>
        <p>Colonnes attendues: type [classe|eleve], name, etablissementId, firstName, lastName, classeId</p>
        <form action="/api/import/excel" method="post" encType="multipart/form-data">
          <input type="file" name="file" accept=".xlsx,.xls" />
          <button type="submit">Importer</button>
        </form>
      </main>
    </>
  );
}


