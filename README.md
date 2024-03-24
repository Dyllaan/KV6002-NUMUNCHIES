# NU-Munchies (Northumbria Web Team Project - Food Waste)

## Prerequisites
- Docker installed on your device
- NodeJS / Bun on your device
- Internet Connection

## Technologies Used

This project requires Docker, Node JS, PHP and an internet connection to connect to the Supabase
Database and to connect to the Email server which handles sending of emails. All required libraries for the backend are included in the version control, and as such it is a large file size, this makes installation across different devices easier. The frontend libraries are not included in the version controlled directory but can be easilly installed via npm or other package manager.

### Backend
- Frankenphp - PHP runtime
- Caddy - reverse proxy
- Composer - managing packages
- Docker - for running the server 
- Stripe library - for handling payments
- Firebase/JWT library for handling JWT tokens
- PHPMailer for sending emails

### Frontend
- Next.js 14 - for rendering frontend
- Node.js/Bun - for managing packages
- Shadcn UI - UI library with reusable components
- Radix, Lucide and Hero icon sets
- Zod for input validation
- Jotai for global state management
- Other 3rd party utility libraries (datafns, swr, etc.)

## Installation

### Backend
**1. Start the Docker service on your PC**

Firstly, a Docker service must be running on your device. If you have not started it yet, this can be done by starting the "Docker Desktop" application on your device.

**2. Change directory to the backend folder**

```sh
cd backend
```

**3. Run Docker Compose command**

This will start a local development server on your PC. The server is running on `localhost:8080`
```sh
docker-compose up
```

### Frontend

**1. Change directory to the frontend folder**

```sh
cd frontend
```

**2. Install external packages**

With Bun:

```
bun i
```
Or with Node.js:
```
npm i
```

**3. Run the development server**

```
bun dev
```


# Deployed Version

The production version of this application is deployed to the internet. Below are listed urls for the API and the frontend interface. The hosting platform used for hosting backend is Fly.io and for frontend Vercel.

## The frontend is accessible via:
[https://nu-munchies.xyz](https://nu-munchies.xyz)

## The backend is accesible via:
[https://backend.nu-munchies.xyz](https://backend.nu-munchies.xyz)
