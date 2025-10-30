import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const classeId = searchParams.get('classeId') || undefined;
  const eleveId = searchParams.get('eleveId') || undefined;

  // stats globales ou filtrées
  const where: any = {};
  if (eleveId) where.eleveId = eleveId;
  if (classeId) where.eleve = { classeId };

  const [count, avgScore, maxScore, minScore] = await Promise.all([
    prisma.result.count({ where }),
    prisma.result.aggregate({ _avg: { score: true }, where }),
    prisma.result.aggregate({ _max: { score: true }, where }),
    prisma.result.aggregate({ _min: { score: true }, where })
  ]);

  return NextResponse.json({
    total: count,
    averageScore: avgScore._avg.score ?? 0,
    bestScore: maxScore._max.score ?? 0,
    worstScore: minScore._min.score ?? 0
  });
}


