import type { User } from "../types/user";

type Props = {
    users: User[];
    onEdit?: (u: User) => void;
    onDelete?: (dni: string) => void; 
};

export default function UsersTable({ users, onEdit, onDelete }: Props) {
    if (!users.length) return <p>No hay usuarios para mostrar.</p>;
    return (
        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
                <tr>
                    <th style={{ textAlign: 'left' }}>ID</th>
                    <th style={{ textAlign: 'left' }}>Nombre</th>
                    <th style={{ textAlign: 'left' }}>Apellido</th>
                    <th style={{ textAlign: 'left' }}>DNI</th>
                    <th style={{ textAlign: 'left' }}>Ciudad</th>
                    <th style={{ textAlign: 'left' }}>Activo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {users.map(u => (
                    <tr key={u.id}>
                        <td>{u.id}</td>
                        <td>{u.nombre}</td>
                        <td>{u.apellido}</td>
                        <td>{u.dni}</td>
                        <td>{u.ciudad}</td>
                        <td>{u.activo ? 'Sí' : 'No'}</td>
                        <td style={{ display: 'flex', gap: 8 }}>
                            {onEdit && <button onClick={() => onEdit(u)}>Editar</button>}
                            {onDelete && <button onClick={() => onDelete(u.dni)}>Eliminar</button>}
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
}
