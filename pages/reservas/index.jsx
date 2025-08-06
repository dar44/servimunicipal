import { useEffect, useState } from 'react'
import { supabase } from '../../lib/supabaseClient'

export default function ReservasPage() {
  const [reservas, setReservas] = useState([])
  const [error, setError] = useState(null)

  useEffect(() => {
    const fetchReservas = async () => {
      const { data: { session } } = await supabase.auth.getSession()
      if (!session) {
        setError('Usuario no autenticado')
        return
      }

      try {
        const res = await fetch('/api/reservas', {
          headers: { Authorization: `Bearer ${session.access_token}` },
        })

        if (!res.ok) {
          const err = await res.json()
          setError(err.error || 'Error al cargar las reservas')
          return
        }

        const data = await res.json()
        setReservas(data)
      } catch (err) {
        setError(err.message)
      }
    }

    fetchReservas()
  }, [])

  const handleDelete = async (id) => {
    const { data: { session } } = await supabase.auth.getSession()
    if (!session) return

    const res = await fetch(`/api/reservas/${id}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${session.access_token}` },
    })

    if (res.ok) {
      setReservas((current) => current.filter((r) => r.id !== id))
    } else {
      const err = await res.json()
      alert(err.error || 'Error al eliminar')
    }
  }

  if (error) {
    return <p>{error}</p>
  }

  return (
    <div>
      <h1>Mis Reservas</h1>
      <ul>
        {reservas.map((r) => (
          <li key={r.id}>
            {new Date(r.start_at).toLocaleString()} - {new Date(r.end_at).toLocaleString()}
            <button onClick={() => handleDelete(r.id)}>Eliminar</button>
          </li>
        ))}
      </ul>
    </div>
  )
}
