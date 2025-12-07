# CV Analyzer

Aplicación web construida con Laravel para subir currículums (PDF/DOC/DOCX), extraer su contenido, clasificarlos mediante un script en Python y validar si el postulante coincide con un puesto definido según habilidades.

**Estado:** Proyecto en desarrollo

**Tecnologías principales:** PHP 8.2, Laravel 11, Vite, Tailwind CSS, Python (scikit-learn)

**Características principales**
- Subida de documentos (`pdf`, `doc`, `docx`) y extracción de texto.
- Conversión automática de archivos Word (`.doc`, `.docx`) a PDF.
- Clasificación básica de carrera/profesión mediante un script de Python y coincidencia de habilidades.
- Visualización y gestión de documentos (ver, aprobar, eliminar).

**Estructura importante**
- `app/Http/Controllers` — Controladores principales (subida, conversión, resultados y validación).
- `app/Models` — Modelos: `Document`, `Position`, `Hability`.
- `resources/views` — Vistas Blade para UI.
- `routes/web.php` — Rutas públicas principales.
- `python_scripts/validar_curriculum.py` — Script de entrenamiento/validación (scikit-learn).

**Requisitos**
- PHP >= 8.2
- Composer
- Node.js + npm
- `pdftotext` (poppler) instalado en el sistema (para extraer texto de PDFs)
- Python 3 + paquetes: `scikit-learn`, `joblib`

**Dependencias principales (composer)**
- `phpoffice/phpword` — Conversión Word → PDF
- `spatie/pdf-to-text` — Extracción de texto desde PDF
- `tecnickcom/tcpdf` — Generación de PDF desde PHPWord
- `symfony/process` — Ejecutar procesos (p.ej. llamar a Python)

**Dependencias front-end**
- `vite`, `tailwindcss`, `axios`, `animate.css`

**Instalación (rápida)**
1. Clona el repositorio:

```
git clone <repo_url>
cd cv-analyzer
```

2. Instala dependencias PHP y Node:

```
composer install
npm install
```

3. Copia el `.env` y genera la clave de aplicación:

```
cp .env.example .env
php artisan key:generate
```

4. Crea el enlace público para almacenamiento y ejecuta migraciones + seeders:

```
php artisan storage:link
php artisan migrate --seed
```

5. Compila assets (modo desarrollo):

```
npm run dev
```

6. Levanta el servidor local de Laravel (opcional):

```
php artisan serve
```

**Python: entrenar / probar el clasificador**

El script `python_scripts/validar_curriculum.py` crea (y guarda) un pipeline de scikit-learn en `python_scripts/career_classifier_pipeline.pkl` y espera como argumento un texto a clasificar.

Instalar dependencias Python:

```
python3 -m pip install -r python_scripts/requirements.txt || python3 -m pip install scikit-learn joblib
```

Ejecutar (entrena + prueba rápidamente):

```
python3 python_scripts/validar_curriculum.py "Texto de ejemplo para clasificar"
```

Notas:
- El script incluye datos de ejemplo para las categorías `Desarrollador` y `Contador`. Puedes ampliar el dataset y ajustar el pipeline según sea necesario.

**Rutas importantes**
- `GET /` → `HomeController@index` (inicio)
- `GET /import-cv` → Formulario para subir CV (`CvController@index`)
- `POST /upload` → Subida y procesamiento del documento (`DocumentContrller@store`)
- `GET /documents/{id}` → Ver contenido extraído (`DocumentResultController@index`)
- `GET /validate-applicant/{id}` → Ejecuta validación con Python (`ValidarPostulanteController@getPredictionFromPython`)
- `POST /validate-applicant/approve/{id}` → Aprobar documento
- `GET /validate-applicant/delete/{id}` → Eliminar documento
- `GET /all-documents` → Listar todos los documentos
- `GET /document/{id}` → Ver documento individual

**Base de datos (resumen de tablas)**
- `positions` — campos: `id`, `name`, `is_active`, `timestamps`.
- `documents` — campos: `id`, `name`, `content`, `position_id`, `approved`, `timestamps`.
- `habilities` — campos: `id`, `name`, `description`, `position_id`, `timestamps`.

**Consideraciones / Notas técnicas**
- Extracción de texto de PDFs: el código actual instancia `Spatie\\PdfToText\\Pdf` con una ruta a `pdftotext` que está codificada para Windows (`D:\\poppler-...`). En Linux debes instalar `poppler-utils` y asegurarte de que `pdftotext` esté en el `PATH`.
	- Recomendación: modificar el código para leer la ruta de `pdftotext` desde una variable de entorno (`POPPLER_PATH`) o eliminar el parámetro si `pdftotext` está en `PATH`.

- Conversión de Word a PDF: se usa `phpoffice/phpword` con `tcpdf` como renderer. Asegúrate de que `tecnickcom/tcpdf` esté instalado correctamente.

- El script de Python se ejecuta desde PHP mediante `symfony/process`. Asegúrate de tener el ejecutable `python3` disponible y permisos adecuados.

**Próximos pasos sugeridos**
- Externalizar la ruta de `pdftotext` a `.env` (`POPPLER_PATH`).
- Añadir tests unitarios/feature para endpoints críticos.
- Mejorar y ampliar el dataset del clasificador y separar el script de entrenamiento del de inferencia.

---