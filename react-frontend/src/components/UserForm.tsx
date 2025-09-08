import { useState } from 'react';
import type { User, CreateUserDTO } from '../types/user';

interface Props {
    initial?: Partial<User>;
    onSubmit: (payload: CreateUserDTO) => Promise<void> | void;
}

export default function UserForm({ initial, onSubmit }: Props) {
    const [nombre, setNombre] = useState(initial?.nombre ?? '');
    const [apellido, setApellido] = useState(initial?.apellido ?? '');
    const [dni, setDni] = useState(initial?.dni ?? '');
    const [fechaNacimiento, setFechaNacimiento] = useState(initial?.fechaNacimiento ?? '');
    const [ciudad, setCiudad] = useState(initial?.ciudad ?? '');
    const activo = true;
    
    return (
        <form onSubmit={async (e) => {
            e.preventDefault();
            await onSubmit({ nombre, apellido, dni, fechaNacimiento, ciudad, activo });
        }} style={{ display: 'grid', gap: 12, maxWidth: 480 }}>
            <input placeholder="Nombre" value={nombre} onChange={e => setNombre(e.target.value)} />
            <input placeholder="Apellido" value={apellido} onChange={e => setApellido(e.target.value)} />
            <input placeholder="DNI" value={dni} onChange={e => setDni(e.target.value)} />
            <input type="date" placeholder="Fecha de nacimiento" value={fechaNacimiento} onChange={e => setFechaNacimiento(e.target.value)} />
            <input placeholder="Ciudad" value={ciudad} onChange={e => setCiudad(e.target.value)} />
            <button type="submit">Guardar</button>
        </form>
    );
}
