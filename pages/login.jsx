import { useState } from 'react';
import Link from 'next/link';
import FormField from '../components/FormField';

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    // TODO: send login request
  };

  return (
    <div className="container">
      <h1>Iniciar Sesión</h1>
      <form onSubmit={handleSubmit}>
        <FormField label="Email" type="email" value={email} onChange={setEmail} />
        <FormField label="Contraseña" type="password" value={password} onChange={setPassword} />
        <button type="submit" className="btn btn-primary">Entrar</button>
      </form>
      <p className="mt-3">
        ¿No tienes cuenta? <Link href="/register">Registrarse</Link>
      </p>
    </div>
  );
}
