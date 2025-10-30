import { NextRequest } from 'next/server';
import PDFDocument from 'pdfkit';

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const name = searchParams.get('name') || 'Élève';

  const doc = new PDFDocument({ margin: 50, size: 'A4' });
  return new Response(
    new ReadableStream({
      start(controller) {
        doc.on('data', (c) => controller.enqueue(c));
        doc.on('end', () => controller.close());

        // En-tête
        doc.fontSize(26).text('Diplôme de Réussite', { align: 'center' });
        doc.moveDown(2);

        // Corps
        doc.fontSize(16).text('Ce diplôme est décerné à:', { align: 'center' });
        doc.moveDown();
        doc.fontSize(22).text(`${name}`, { align: 'center' });
        doc.moveDown(2);
        doc.fontSize(14).text('Pour sa performance au jeu R5.', { align: 'center' });
        doc.moveDown(6);

        // Pied de page simple
        const date = new Date().toLocaleDateString('fr-FR');
        doc.fontSize(12).text(`Fait le ${date}`, { align: 'right' });
        doc.end();
      },
    }),
    {
      headers: {
        'Content-Type': 'application/pdf',
        'Content-Disposition': `inline; filename="diplome_${encodeURIComponent(name)}.pdf"`,
      },
    }
  );
}


