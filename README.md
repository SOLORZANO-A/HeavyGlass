# Heavy Glass – Sistema de Gestión de Taller Automotriz

Proyecto Final – QualityOps: Construcción, Medición y Mejora de Calidad de Software  
Instituto Superior Universitario Sucre  
Asignatura: Calidad de Software / Métricas de Calidad  
Semestre: 4to  

---

## 📌 Descripción del Proyecto

**Heavy Glass** es un sistema web para la gestión integral de un taller automotriz, que permite:

- Gestión de clientes y vehículos
- Registro de hojas de ingreso
- Órdenes de trabajo con asignación de técnicos
- Proformas con aprobación del cliente
- Pagos parciales y totales
- Consulta pública del estado del vehículo
- Control de calidad basado en métricas (ISO/IEC 25010 + SQuaRE)

El proyecto está orientado a **demostrar calidad del software mediante evidencia medible**, pruebas, seguridad y mejora continua.

---

## 🧱 Tecnologías Utilizadas

- **Backend:** Laravel 12 (PHP 8.3)
- **Frontend:** Blade + Bootstrap 5 + AdminLTE
- **Base de datos:** MySQL
- **Control de versiones:** Git + GitHub
- **Calidad:** ISO/IEC 25010 – SQuaRE
- **Pruebas:** PHPUnit
- **Seguridad:** Validaciones, control de acceso, roles
- **CI/CD:** GitHub Actions (pipeline de calidad)

---

## ⚙️ Requisitos del Sistema

- PHP >= 8.3
- Composer
- Node.js y NPM
- MySQL
- Git
- Servidor local (Laragon / XAMPP)

---

## 🚀 Instalación del Proyecto

```bash
git clone https://github.com/SOLORZANO-A/HeavyGlass.git
cd HeavyGlass

-- Instalar dependencias PHP
composer install

-- Crear archivo de entorno
cp .env.example .env


Configurar en .env:

DB_DATABASE=heavy_glass
DB_USERNAME=root
DB_PASSWORD=

-- Generar clave
php artisan key:generate

-- Migraciones y seeders
php artisan migrate:fresh --seed

-- Ejecutar el servidor
php artisan serve

-- Usuarios de Prueba
-- ADMIN
user: admintotal@admin.com
password: admin1812
