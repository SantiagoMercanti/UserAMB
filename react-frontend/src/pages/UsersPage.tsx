import { useEffect, useState } from 'react';
import UsersTable from '../components/UsersTable';
import UserForm from '../components/UserForm';
import { fetchUsers, fetchUserByDni, createUser, deleteUserByDni } from '../api/users';
import type { User } from '../types/user';

export default function UsersPage() {
    const [users, setUsers] = useState<User[]>([]);
    const [dniQuery, setDniQuery] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);


    async function loadAll() {
        try {
            setLoading(true);
            setError(null);
            const data = await fetchUsers();
            setUsers(data);
        } catch (e: unknown) {
            if (e instanceof Error) {
                setError(e.message);
            } else {
                setError('Error al cargar usuarios');
            }
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => { loadAll(); }, []);

    async function onSearch() {
        if (!dniQuery.trim()) return loadAll();
        try {
            setLoading(true);
            setError(null);
            const u = await fetchUserByDni(dniQuery.trim());
            setUsers(u ? [u] : []);
        } catch {
            setUsers([]);
            setError('No se encontró el usuario');
        } finally {
            setLoading(false);
        }
    }

    async function onCreate(payload: Omit<User, 'id'>) {
        await createUser(payload);
        await loadAll();
    }

    async function onDelete(dni: string) {
        if (!confirm('¿Eliminar (baja lógica) este usuario?')) return;
        await deleteUserByDni(dni);
        await loadAll();
    }

    return (
        <div style={{ display: 'grid', gap: 24, padding: 24 }}>
            <h1>Usuarios</h1>


            <section style={{ display: 'flex', gap: 8 }}>
                <input
                    placeholder="Buscar por DNI"
                    value={dniQuery}
                    onChange={e => setDniQuery(e.target.value)}
                />
                <button onClick={onSearch}>Buscar</button>
                <button onClick={loadAll}>Limpiar</button>
            </section>


            {loading && <p>Cargando...</p>}
            {error && <p style={{ color: 'crimson' }}>{error}</p>}


            <UsersTable users={users} onDelete={onDelete} />


            <section>
                <h2>Crear nuevo usuario</h2>
                <UserForm onSubmit={onCreate} />
            </section>
        </div>
    );
}
