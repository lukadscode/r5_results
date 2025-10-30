import { NextRequest, NextResponse } from 'next/server';
import { createWriteStream } from 'fs';
import { mkdir, stat } from 'fs/promises';
import { join } from 'path';

export async function POST(req: NextRequest) {
  const form = await req.formData();
  const file = form.get('file');
  if (!(file instanceof File)) return NextResponse.json({ error: 'Fichier requis' }, { status: 400 });

  const uploadsDir = join(process.cwd(), 'public', 'uploads');
  try {
    await stat(uploadsDir);
  } catch {
    await mkdir(uploadsDir, { recursive: true });
  }

  const arrayBuffer = await file.arrayBuffer();
  const buffer = Buffer.from(arrayBuffer);
  const filename = `${Date.now()}_${file.name.replace(/[^a-zA-Z0-9_.-]/g, '_')}`;
  const filepath = join(uploadsDir, filename);

  await new Promise<void>((resolve, reject) => {
    const ws = createWriteStream(filepath);
    ws.on('finish', () => resolve());
    ws.on('error', reject);
    ws.end(buffer);
  });

  return NextResponse.json({ ok: true, url: `/uploads/${filename}` });
}


