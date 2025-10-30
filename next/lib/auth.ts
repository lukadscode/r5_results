import { cookies } from 'next/headers';
import { prisma } from './db';

export async function getCurrentUser() {
  const cookieStore = await cookies();
  const id = cookieStore.get('r5_session')?.value;
  if (!id) return null;
  const user = await prisma.user.findUnique({ where: { id } });
  return user;
}

export function requireRole(user: { role: string } | null, roles: string[]) {
  if (!user) return false;
  return roles.includes(user.role);
}


