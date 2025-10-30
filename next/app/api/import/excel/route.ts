import { NextRequest, NextResponse } from 'next/server';
import * as XLSX from 'xlsx';
import { prisma } from '@/lib/db';
import { requireRole } from '@/lib/apiAuth';

export const runtime = 'nodejs';

export async function POST(req: NextRequest) {
  const { allowed } = await requireRole(req, ['ADMIN', 'ETABLISSEMENT', 'PROF']);
  if (!allowed) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  const form = await req.formData();
  const file = form.get('file');
  if (!(file instanceof File)) return NextResponse.json({ error: 'Fichier requis' }, { status: 400 });

  const arrayBuffer = await file.arrayBuffer();
  const buffer = Buffer.from(arrayBuffer);
  const wb = XLSX.read(buffer, { type: 'buffer' });
  const wsName = wb.SheetNames[0];
  const ws = wb.Sheets[wsName];
  const rows = XLSX.utils.sheet_to_json(ws, { defval: '' }) as Array<Record<string, any>>;

  // Convention colonnes: type, name, etablissementId, firstName, lastName, classeId
  // type = 'classe' ou 'eleve'
  let createdClasses = 0;
  let createdEleves = 0;

  await prisma.$transaction(async (tx) => {
    for (const r of rows) {
      const type = String(r.type || '').toLowerCase();
      if (type === 'classe') {
        const name = String(r.name || '').trim();
        const etablissementId = String(r.etablissementId || '').trim();
        if (!name || !etablissementId) continue;
        await tx.classe.create({ data: { name, etablissementId } });
        createdClasses += 1;
      } else if (type === 'eleve') {
        const firstName = String(r.firstName || '').trim();
        const lastName = String(r.lastName || '').trim();
        const classeId = String(r.classeId || '').trim();
        if (!firstName || !lastName || !classeId) continue;
        await tx.eleve.create({ data: { firstName, lastName, classeId } });
        createdEleves += 1;
      }
    }
  });

  return NextResponse.json({ ok: true, createdClasses, createdEleves });
}


