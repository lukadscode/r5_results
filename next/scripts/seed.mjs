import { PrismaClient } from '@prisma/client';
import bcrypt from 'bcryptjs';

const prisma = new PrismaClient();

async function main() {
  const email = 'admin@r5.local';
  const name = 'Administrateur';
  const password = 'admin12345';

  const existing = await prisma.user.findUnique({ where: { email } });
  if (existing) {
    console.log('Admin déjà présent.');
    return;
  }
  const hash = await bcrypt.hash(password, 10);
  await prisma.user.create({ data: { email, name, password: hash, role: 'ADMIN' } });
  console.log('Admin créé:', email, 'mdp:', password);
}

main().catch((e) => {
  console.error(e);
  process.exit(1);
}).finally(async () => {
  await prisma.$disconnect();
});


