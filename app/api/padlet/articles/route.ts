import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';
import { requireRole } from '@/lib/apiAuth';

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const categoryId = searchParams.get('categoryId') || undefined;
  const where = categoryId ? { categoryId } : {};
  const items = await prisma.padletArticle.findMany({ where, orderBy: { createdAt: 'desc' } });
  return NextResponse.json({ items });
}

export async function POST(req: NextRequest) {
  const { allowed } = await requireRole(req, ['ADMIN', 'ETABLISSEMENT', 'PROF']);
  if (!allowed) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });
  const { title, content, categoryId, status, createdBy } = await req.json();
  if (!title || !content || !categoryId || !createdBy) return NextResponse.json({ error: 'Champs requis' }, { status: 400 });
  const item = await prisma.padletArticle.create({ data: { title, content, categoryId, status, createdBy } });
  return NextResponse.json({ item });
}


