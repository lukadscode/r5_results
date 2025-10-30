import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';
import { requireRole } from '@/lib/apiAuth';

export async function GET() {
  const items = await prisma.padletCategory.findMany({ orderBy: { name: 'asc' } });
  return NextResponse.json({ items });
}

export async function POST(req: NextRequest) {
  const { allowed } = await requireRole(req, ['ADMIN', 'ETABLISSEMENT', 'PROF']);
  if (!allowed) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });
  const { name } = await req.json();
  if (!name) return NextResponse.json({ error: 'Nom requis' }, { status: 400 });
  const item = await prisma.padletCategory.create({ data: { name } });
  return NextResponse.json({ item });
}


