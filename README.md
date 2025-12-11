
# CV Analyzer

Aplicación web Laravel para analizar currículums, extraer texto, clasificarlos con Python y validar habilidades para distintos puestos.

## Requisitos

- **PHP >= 8.2** (CLI y extensiones: dom, xml, mbstring, zip, intl, sqlite3)
- **Composer**
- **Node.js + npm**
- **Python 3.12+**
- **poppler-utils** (`pdftotext` en el sistema)

## Instalación paso a paso (Linux)

## Despliegue en Railway

1. Sube el repositorio a GitHub.
2. Ve a [railway.app](https://railway.app) y crea un nuevo proyecto desde tu repo.
3. Añade las variables de entorno necesarias en el panel de Railway:
	- APP_KEY (genera con `php artisan key:generate`)
	- APP_ENV=production
	- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD (según la base de datos que elijas)
	- PYTHON_PATH=/usr/bin/python3
	- POPPLER_PATH=/usr/bin/pdftotext
4. Railway detecta Laravel automáticamente y ejecuta migraciones.
5. Configura la base de datos desde Railway y actualiza las variables en el panel.
6. Añade el comando post-deploy: `php artisan migrate --force`
7. El almacenamiento y los archivos públicos funcionan por defecto.
8. Si usas Python, asegúrate de tener `python_scripts/requirements.txt` en el repo.

1. **Clona el repositorio:**
	```bash
	git clone <repo_url>
	cd cv-analyzer
	```

2. **Instala dependencias PHP y Node:**
	```bash
	composer install
	npm install
	```

3. **Instala extensiones PHP necesarias:**
	```bash
	sudo apt update
	sudo apt install -y php8.2-xml php8.2-mbstring php8.2-zip php8.2-intl php8.2-sqlite3 poppler-utils
	```

4. **Configura el entorno:**
	```bash
	cp .env.example .env
	php artisan key:generate
	```

5. **Configura la base de datos MySQL/PostgreSQL:**
	- En Railway, crea una base de datos desde el panel y copia las credenciales.
	- En `.env` (o en el panel de Railway) configura:
	  ```env
	  DB_CONNECTION=mysql # o pgsql
	  DB_HOST=...        # host proporcionado por Railway
	  DB_PORT=3306       # o 5432 para Postgres
	  DB_DATABASE=...    # nombre de la base de datos
	  DB_USERNAME=...    # usuario
	  DB_PASSWORD=...    # contraseña
	  ```
	- No uses SQLite en producción.

6. **Crea el enlace público y ejecuta migraciones:**
	```bash
	php artisan storage:link
	php artisan migrate --force
	# Si quieres poblar datos:
	php artisan db:seed --force
	```

7. **Compila assets front-end:**
	```bash
	npm run dev
	```

8. **Instala y configura Python + dependencias:**
	```bash
	sudo apt install -y python3-venv build-essential python3-dev libatlas-base-dev gfortran
	python3 -m venv .venv
	source .venv/bin/activate
	pip install --upgrade pip setuptools wheel
	pip install scikit-learn joblib
	echo "PYTHON_PATH=$(pwd)/.venv/bin/python" >> .env
	php artisan config:clear
	```

9. **Configura la ruta de pdftotext en `.env` (opcional):**
	```env
	POPPLER_PATH=/usr/bin/pdftotext
	```

10. **Levanta el servidor local de Laravel:**
	```bash
	php artisan serve
	```

## Estructura principal

- `app/Http/Controllers` — Lógica de negocio y endpoints
- `app/Models` — Modelos Eloquent
- `resources/views` — Vistas Blade
- `routes/web.php` — Rutas principales
- `python_scripts/validar_curriculum.py` — Clasificador Python

## Rutas importantes

- `GET /` — Home
- `GET /import-cv` — Formulario de subida de CV
- `POST /upload` — Subida y procesamiento de documento
- `GET /documents/{id}` — Ver contenido extraído
- `GET /validate-applicant/{id}` — Validación con Python
- `POST /validate-applicant/approve/{id}` — Aprobar documento
- `GET /validate-applicant/delete/{id}` — Eliminar documento
- `GET /all-documents` — Listar todos los documentos
- `GET /document/{id}` — Ver documento individual

## Notas técnicas y recomendaciones

- El código usa variables de entorno `POPPLER_PATH` y `PYTHON_PATH` para máxima portabilidad.
- El script Python se ejecuta en un venv y desde el directorio `python_scripts` para evitar errores de rutas relativas.
- Si el texto del CV es muy largo, considera modificar el controlador para pasar el texto por archivo temporal en vez de argumento CLI.
- Para desarrollo, SQLite es suficiente; para producción, configura MySQL/MariaDB en `.env`.
- Si usas Windows, instala poppler y ajusta `POPPLER_PATH` a la ruta del ejecutable.

## Troubleshooting

- **Error de pdftotext:** Asegúrate de tener `poppler-utils` instalado y la ruta correcta en `.env`.
- **Error de Python:** Verifica que el venv esté creado y `PYTHON_PATH` apunte al ejecutable correcto.
- **Extensiones PHP faltantes:** Instala los paquetes indicados arriba.

## Créditos y licencia

Proyecto desarrollado por Kevingedev y colaboradores. Licencia MIT.