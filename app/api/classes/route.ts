import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';
import { requireAuth, requireRole } from '@/lib/apiAuth';

export async function GET() {
  const items = await prisma.classe.findMany({ orderBy: { createdAt: 'desc' } });
  return NextResponse.json({ items });
}

export async function POST(req: NextRequest) {
  const { allowed } = await requireRole(req, ['ADMIN', 'ETABLISSEMENT', 'PROF']);
  if (!allowed) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });
  const { name, etablissementId } = await req.json();
  if (!name || !etablissementId) return NextResponse.json({ error: 'Champs requis' }, { status: 400 });
  const item = await prisma.classe.create({ data: { name, etablissementId } });
  return NextResponse.json({ item });
}


