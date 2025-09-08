<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use InvalidArgumentException;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(private UserManager $um) {}

    // Listar todos los usuarios activos
    #[Route('', name: 'user_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $usuarios = $this->um->listarActivos();
        $data = array_map(fn(User $u) => [
            'id' => $u->getId(),
            'nombre' => $u->getNombre(),
            'apellido' => $u->getApellido(),
            'dni' => $u->getDni(),
            'fechaNacimiento' => $u->getFechaNacimiento()?->format('Y-m-d'),
            'ciudad' => $u->getCiudad(),
            'activo' => $u->isActivo(),
        ], $usuarios);

        return $this->json($data);
    }

    // Crear un usuario
    #[Route('', name: 'user_create', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);

        try {
            $user = $this->um->alta(
                $data['nombre'],
                $data['apellido'],
                $data['dni'],
                new \DateTime($data['fechaNacimiento']),
                $data['ciudad']
            );
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

        return $this->json([
            'id' => $user->getId(),
            'dni' => $user->getDni(),
        ], 201);
    }


    // Desactivar (baja lógica)
    #[Route('/{dni}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(string $dni): JsonResponse
    {
        $u = $this->um->obtenerPorDni($dni);
        if (!$u) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $this->um->desactivar($u);

        return $this->json(['status' => 'Usuario desactivado']);
    }



    // Obtener uno por DNI
    #[Route('/{dni}', name: 'user_get', methods: ['GET'])]
    public function getOne(string $dni): JsonResponse
    {
        $u = $this->um->obtenerPorDni($dni);
        if (!$u || !$u->isActivo()) {
            return $this->json(['error' => 'Usuario no encontrado o inactivo'], 404);
        }

        return $this->json([
            'id' => $u->getId(),
            'nombre' => $u->getNombre(),
            'apellido' => $u->getApellido(),
            'dni' => $u->getDni(),
            'fechaNacimiento' => $u->getFechaNacimiento()?->format('Y-m-d'),
            'ciudad' => $u->getCiudad(),
            'activo' => $u->isActivo(),
        ]);
    }

    // Editar (PUT/PATCH) campos simples
    #[Route('/{dni}', name: 'user_update', methods: ['PUT', 'PATCH'])]
    public function update(string $dni, Request $req): JsonResponse
    {
        $u = $this->um->obtenerPorDni($dni);
        if (!$u) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $data = json_decode($req->getContent(), true) ?? [];
        try {
            $u = $this->um->editar(
                $u,
                $data['nombre']   ?? null,
                $data['apellido'] ?? null,
                $data['ciudad']   ?? null,
                isset($data['fechaNacimiento']) ? new \DateTime($data['fechaNacimiento']) : null
            );
        } catch (InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

        return $this->json(['status' => 'Usuario actualizado']);
    }

    // Reactivar
    #[Route('/{dni}/reactivar', name: 'user_reactivate', methods: ['POST'])]
    public function reactivate(string $dni): JsonResponse
    {
        $u = $this->um->obtenerPorDni($dni);
        if (!$u) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $this->um->reactivar($u);
        return $this->json(['status' => 'Usuario reactivado']);
    }
}
