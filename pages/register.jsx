import { useState } from 'react';
import Link from 'next/link';
import FormField from '../components/FormField';

export default function Register() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirmation, setPasswordConfirmation] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    // TODO: send registration request
  };

  return (
    <div className="container">
      <h1>Registrarse</h1>
      <form onSubmit={handleSubmit}>
        <FormField label="Nombre" type="text" value={name} onChange={setName} />
        <FormField label="Email" type="email" value={email} onChange={setEmail} />
        <FormField label="Contraseña" type="password" value={password} onChange={setPassword} />
        <FormField label="Confirmar Contraseña" type="password" value={passwordConfirmation} onChange={setPasswordConfirmation} />
        <button type="submit" className="btn btn-primary">Crear Cuenta</button>
      </form>
      <p className="mt-3">
        ¿Ya tienes cuenta? <Link href="/login">Iniciar Sesión</Link>
      </p>
    </div>
  );
}
