import Link from 'next/link';

export default function NavBar() {
  return (
    <nav className="navbar navbar-expand-md navbar-light bg-primary shadow-sm" data-bs-theme="dark">
      <div className="container">
        <Link className="navbar-brand fs-4" href="/">
          ServiMunicipal
        </Link>
        <ul className="navbar-nav ms-auto">
          <li className="nav-item">
            <Link className="nav-link fs-5" href="/login">Iniciar Sesión</Link>
          </li>
          <li className="nav-item">
            <Link className="nav-link fs-5" href="/register">Registrarse</Link>
          </li>
        </ul>
      </div>
    </nav>
  );
}
