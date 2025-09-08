# UserABM — Symfony + MySQL + Docker (backend) & React + Vite (frontend)

ABM de usuarios con **API en Symfony** y **frontend en React (Vite + TypeScript)**.
La base de datos es **MySQL 8** y se gestiona con **Docker Compose**.
El frontend se ejecuta **local** con Node (no va en Docker).

## Stack

* **Backend:** PHP 8 / Symfony, MySQL 8, phpMyAdmin, Docker Compose
* **Frontend:** React + Vite + TypeScript (Node 18+)


## Requisitos

* **Docker Desktop** (incluye Docker Compose v2)
* **Node.js 18+** y **npm**

---

## Backend (Docker)

El `docker-compose.yml` (versión `3.9`) define tres servicios:

* **MySQL (`db`)**: expuesto en `localhost:3306`, DB `users_db`, user `app`, pass `app`.
* **phpMyAdmin (`phpmyadmin`)**: UI en `http://localhost:8080` (PMA\_HOST=`db`, user=`app`, pass=`app`).
* **Symfony (`symfony`)**: API servida en `http://localhost:8000`.

### Comandos básicos

```bash
# levantar backend (detached)
docker compose up -d

# ver estado y puertos
docker compose ps

# logs (ej. del servicio symfony o mysql)
docker compose logs -f users_symfony
docker compose logs -f users_mysql

# detener / reanudar
docker compose stop
docker compose start

# bajar stack (y borrar contenedores/red)
docker compose down

# bajar stack y borrar volúmenes (⚠️ borra datos)
docker compose down -v
```

---

## Frontend (React + Vite)

El frontend corre fuera de Docker y consume la API en `http://localhost:8000`.

### Variables de entorno

Asegurarse de tener `react-frontend/.env` con:

```
VITE_API_URL=http://localhost:8000
```

### Instalar y correr

```bash
cd react-frontend
npm install
npm run dev -- --open   # abre http://localhost:5173
```

### Build y preview (opcional)

```bash
npm run build
npm run preview         # por defecto http://localhost:4173
```

---

## CORS

Asegurarse de tener Nelmio CORS en Symfony para permitir Vite (`http://localhost:5173`):

```yaml
# config/packages/nelmio_cors.yaml
nelmio_cors:
  defaults:
    origin_regex: true
    allow_origin: ['^http://localhost:5173$', '^http://127.0.0.1:5173$']
    allow_methods: ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
    allow_headers: ['Content-Type', 'Authorization']
    max_age: 3600
  paths:
    '^/api/': ~
```

---


