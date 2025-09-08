export type User = {
    id: number;
    nombre: string;
    apellido: string;
    dni: string;
    fechaNacimiento: string; // ISO yyyy-mm-dd
    ciudad: string;
    activo: boolean;
};

export type CreateUserDTO = Omit<User, 'id'>;
export type UpdateUserDTO = Partial<Omit<User, 'id' | 'dni'>>; 