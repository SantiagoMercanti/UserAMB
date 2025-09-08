<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\DniValidator;
use DateTimeInterface;
use InvalidArgumentException;

class UserManager
{
    public function __construct(
        private UserRepository $users,
        private DniValidator $dniValidator
    ) {}

    public function alta(
        string $nombre,
        string $apellido,
        string $dni,
        DateTimeInterface $fechaNacimiento,
        string $ciudad
    ): User {
        // Validar DNI
        if (!$this->dniValidator->isValid($dni)) {
            throw new InvalidArgumentException('DNI inválido');
        }
        if ($this->users->findByDni($dni)) {
            throw new InvalidArgumentException('DNI ya registrado');
        }

        $u = new User();
        $u->setNombre(trim($nombre));
        $u->setApellido(trim($apellido));
        $u->setDni($dni);
        $u->setFechaNacimiento($fechaNacimiento);
        $u->setCiudad(trim($ciudad));
        $u->setActivo(true);

        $this->users->save($u, true);
        return $u;
    }

    public function editar(
        User $u,
        ?string $nombre = null,
        ?string $apellido = null,
        ?string $ciudad = null,
        ?DateTimeInterface $fechaNacimiento = null
    ): User {
        if ($nombre !== null)          $u->setNombre(trim($nombre));
        if ($apellido !== null)        $u->setApellido(trim($apellido));
        if ($ciudad !== null)          $u->setCiudad(trim($ciudad));
        if ($fechaNacimiento !== null) $u->setFechaNacimiento($fechaNacimiento);

        $this->users->save($u, true);
        return $u;
    }

    public function desactivar(User $u): User
    {
        $u->setActivo(false);
        $this->users->save($u, true);
        return $u;
    }

    public function reactivar(User $u): User
    {
        $u->setActivo(true);
        $this->users->save($u, true);
        return $u;
    }

    public function listarActivos(): array
    {
        return $this->users->findActivos();
    }

    public function obtenerPorDni(string $dni): ?User
    {
        return $this->users->findByDni($dni);
    }
}
