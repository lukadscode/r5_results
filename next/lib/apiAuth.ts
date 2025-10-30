import type { NextRequest } from 'next/server';
import { prisma } from './db';

export async function getUserFromRequest(req: NextRequest) {
  const cookie = req.cookies.get('r5_session')?.value;
  if (!cookie) return null;
  const user = await prisma.user.findUnique({ where: { id: cookie } });
  return user;
}

export async function requireAuth(req: NextRequest) {
  const user = await getUserFromRequest(req);
  return user;
}

export async function requireRole(req: NextRequest, roles: Array<'ADMIN' | 'ETABLISSEMENT' | 'PROF' | 'ELEVE'>) {
  const user = await getUserFromRequest(req);
  if (!user) return { allowed: false as const, user: null };
  if (!roles.includes(user.role as any)) return { allowed: false as const, user };
  return { allowed: true as const, user };
}


