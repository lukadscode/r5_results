import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const eleveId = searchParams.get('eleveId') || undefined;
  const where = eleveId ? { eleveId } : {};
  const items = await prisma.result.findMany({ where, orderBy: { createdAt: 'desc' }, take: 200 });
  return NextResponse.json({ items });
}


