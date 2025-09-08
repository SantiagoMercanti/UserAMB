import type { CreateUserDTO, UpdateUserDTO, User } from '../types/user';
import api from './http';

// Obtener lista
export async function fetchUsers(): Promise<User[]> {
    const { data } = await api.get('/api/users');
    return data;
}

// Buscar por DNI
export async function fetchUserByDni(dni: string): Promise<User> {
    const { data } = await api.get(`/api/users/${dni}`);
    return data;
}

// Crear
export async function createUser(payload: CreateUserDTO): Promise<User> {
    const { data } = await api.post('/api/users', payload);
    return data;
}

// Actualizar por dni
export async function updateUserByDni(dni: string, payload: UpdateUserDTO): Promise<User> {
    const { data } = await api.put(`/api/users/${dni}`, payload);
    return data;
}

export async function deleteUserByDni(dni: string): Promise<void> {
    await api.delete(`/api/users/${dni}`);
}

export async function reactivateUser(dni: string): Promise<void> {
    await api.post(`/api/users/${dni}/reactivar`);
}