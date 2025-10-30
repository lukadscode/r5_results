import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';
import { requireRole } from '@/lib/apiAuth';

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const classeId = searchParams.get('classeId') || undefined;
  const where = classeId ? { classeId } : {};
  const items = await prisma.eleve.findMany({ where, orderBy: { lastName: 'asc' } });
  return NextResponse.json({ items });
}

export async function POST(req: NextRequest) {
  const { allowed } = await requireRole(req, ['ADMIN', 'ETABLISSEMENT', 'PROF']);
  if (!allowed) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });
  const { firstName, lastName, classeId } = await req.json();
  if (!firstName || !lastName || !classeId) return NextResponse.json({ error: 'Champs requis' }, { status: 400 });
  const item = await prisma.eleve.create({ data: { firstName, lastName, classeId } });
  return NextResponse.json({ item });
}


