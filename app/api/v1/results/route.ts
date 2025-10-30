import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/lib/db';
import { computeHmacSHA256, safeEqual } from '@/lib/hmac';

export async function POST(req: NextRequest) {
  const secret = process.env.RESULTS_HMAC_SECRET || '';
  if (!secret) return NextResponse.json({ error: 'Server misconfigured' }, { status: 500 });

  const raw = await req.text();
  const signature = req.headers.get('x-signature') || '';
  const expected = computeHmacSHA256(raw, secret);
  if (!safeEqual(signature, expected)) {
    return NextResponse.json({ error: 'Invalid signature' }, { status: 401 });
  }

  let body: any;
  try {
    body = JSON.parse(raw);
  } catch {
    return NextResponse.json({ error: 'Invalid JSON' }, { status: 400 });
  }

  const {
    externalEventId,
    gameId,
    classeId,
    eleves,
    metadata
  } = body || {};

  if (!externalEventId || !gameId || !classeId || !Array.isArray(eleves)) {
    return NextResponse.json({ error: 'Missing required fields' }, { status: 400 });
  }

  try {
    const result = await prisma.$transaction(async (tx) => {
      // ensure idempotence
      const existing = await tx.result.findUnique({ where: { externalEventId } });
      if (existing) return existing;

      // basic upsert flow for each eleve score
      let last: any = null;
      for (const item of eleves) {
        const { eleveId, score, temps, details } = item;
        if (!eleveId || typeof score !== 'number') continue;
        last = await tx.result.create({
          data: {
            eleveId,
            score,
            timeSeconds: typeof temps === 'number' ? temps : 0,
            details: details ?? metadata ?? {},
            externalEventId,
            gameId
          }
        });
      }
      return last;
    });

    return NextResponse.json({ ok: true, resultId: result?.id ?? null });
  } catch (e) {
    return NextResponse.json({ error: 'Server error' }, { status: 500 });
  }
}


