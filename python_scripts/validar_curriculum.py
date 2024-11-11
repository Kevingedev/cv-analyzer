from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import make_pipeline
from sklearn import metrics
import joblib
import re
import json
import sys

# Lista de palabras que deseas omitir
custom_stopwords = {"e", "en", "la", "de", "los", "con"}

# Función para limpiar el texto
def remove_stopwords(text, stopwords):
    words = text.lower().split()
    return ' '.join(word for word in words if word not in stopwords)

# Datos de ejemplos
data = [
    # Desarrollador
    {"text": "Desarrollo web, HTML, CSS, JavaScript", "label": "Desarrollador"},
    {"text": "Contabilidad financiera, balance general, estados financieros", "label": "Contabilidad"},
    {"text": "Bases de datos, SQL Server, MySQL", "label": "Desarrollador"},
    {"text": "Auditoría interna, análisis de riesgos, control financiero", "label": "Contabilidad"},
    {"text": "Backend, Node.js, Express", "label": "Desarrollador"},
    {"text": "Gestión de impuestos, declaraciones fiscales, IVA", "label": "Contabilidad"},
    {"text": "Aplicaciones móviles, Android Studio, Java", "label": "Desarrollador"},
    {"text": "Cálculo de nómina, deducciones, retenciones", "label": "Contabilidad"},
    {"text": "Machine Learning, Python, TensorFlow", "label": "Desarrollador"},
    {"text": "Contabilidad de costos, análisis de costos de producción", "label": "Contabilidad"},
    {"text": "Aplicaciones de escritorio, C++, Visual Studio", "label": "Desarrollador"},
    {"text": "Flujo de caja, proyecciones financieras, conciliaciones bancarias", "label": "Contabilidad"},
    {"text": "PHP, Laravel, bases de datos relacionales", "label": "Desarrollador"},
    {"text": "Contabilidad de activos fijos, depreciación, amortización", "label": "Contabilidad"},
    {"text": "Gestión de APIs, RESTful, JSON", "label": "Desarrollador"},
    {"text": "Control de cuentas por cobrar, cuentas por pagar, gestión de cobros", "label": "Contabilidad"},
    {"text": "Frontend, React, Vue.js", "label": "Desarrollador"},
    {"text": "Preparación de informes financieros mensuales, trimestrales", "label": "Contabilidad"},
    {"text": "Desarrollo ágil, Scrum, Git", "label": "Desarrollador"},
    {"text": "Software contable, QuickBooks, SAP, Contpaqi", "label": "Contabilidad"},
    {"text": "Desarrollo en la nube, AWS, Azure", "label": "Desarrollador"},
    {"text": "Análisis de balances, razon de liquidez, solvencia", "label": "Contabilidad"},
    {"text": "Automatización de pruebas, Selenium, Cypress", "label": "Desarrollador"},
    {"text": "Presupuesto empresarial, planificación financiera, previsión de ingresos", "label": "Contabilidad"},
    {"text": "Ecommerce, Magento, WooCommerce", "label": "Desarrollador"},
    {"text": "Contabilidad fiscal, impuestos sobre la renta, IVA, ISR", "label": "Contabilidad"},
    {"text": "Inteligencia artificial, scikit-learn, NLP", "label": "Desarrollador"},
    {"text": "Conciliación contable, revisión de estados bancarios, ajustes contables", "label": "Contabilidad"},
    {"text": "Desarrollador full-stack, MongoDB, GraphQL", "label": "Desarrollador"},
    {"text": "Normas contables, IFRS, NIIF, normativas fiscales", "label": "Contabilidad"},
]

# Extraer el texto y las etiquetas
texts = [item['text'] for item in data]
labels = [item['label'] for item in data]

# Divide los datos en entrenamiento y prueba
X_train, X_test, Y_train, Y_test = train_test_split(texts, labels, test_size=0.3, random_state=42)

# Crear un pipeline que incluya vectorización y modelo
pipeline = make_pipeline(
    TfidfVectorizer(stop_words="english"),
    MultinomialNB()
)

# Entrenar el pipeline con los datos de entrenamiento
pipeline.fit(X_train, Y_train)

# Guardar el modelo completo en un solo archivo
joblib.dump(pipeline, '../python_scripts/career_classifier_pipeline.pkl')

# Evaluar en el conjunto de prueba
predictions = pipeline.predict(X_test)
accuracy = metrics.accuracy_score(Y_test, predictions)

# Extraer palabras clave de cada categoría
keywords = {
    "Desarrollador": set(),
    "Contabilidad": set()
}
for item in data:
    words = set(re.findall(r'\w+', item['text'].lower()))
    keywords[item['label']].update(words)


# Crear un diccionario con los resultados

def get_prediction_and_matches(new_text):
    cleaned_text = remove_stopwords(new_text, custom_stopwords)
    # Realizar la predicción
    prediction = pipeline.predict([cleaned_text])[0]

    # Buscar coincidencias de palabras clave en el texto de entrada
    input_words = set(re.findall(r'\w+', cleaned_text.lower()))
    matches = keywords[prediction].intersection(input_words)
    result = {
        "prediccion": prediction,
        "coincidencias": list(matches) if matches else "Ninguna"
    }
    return json.dumps(result, ensure_ascii=False)

# Prueba con un nuevo texto
# new_text = "Nombre: Juan Carlos Martínez López Dirección: Av. de los Contadores No. 123, Ciudad de México, CDMX Teléfono: +52 55 1234 5678 Correo Electrónico: juancarlos.martinez@email.com LinkedIn: linkedin.com/in/juancarlosmartinez Resumen Profesional Contador Público con más de 8 años de experiencia en auditoría financiera, análisis contable y cumplimiento fiscal. Hábil en la optimización de procesos contables y la implementación de estrategias para el control de costos. Con sólidos conocimientos en normativas fiscales y financieras, y una gran capacidad para manejar múltiples proyectos y equipos de trabajo. Experto en sistemas contables ERP y software de contabilidad, con capacidad analítica y atención al detalle. Experiencia Laboral Senior Contable y Auditor Grupo Financiero Martínez & Asociados, Ciudad de México Enero 2020 - Actualidad Encabezamiento de auditorías internas y externas, garantizando el cumplimiento de las políticas de la empresa y regulaciones financieras. Implementación de procesos contables que redujeron los errores en un 30% y mejoraron el flujo de información financiera. Asesoría a equipos de contabilidad y gerentes en temas fiscales y financieros, logrando optimizar procesos y reducir costos en un 15%. Contador General Asesores Financieros López, Ciudad de México Febrero 2015 - Diciembre 2019 Gestión de registros contables y generación de reportes financieros mensuales, trimestrales y anuales. Supervisión del cumplimiento de las normas fiscales y regulatorias, previniendo posibles sanciones y optimizando la carga fiscal de la empresa. Análisis financiero para la toma de decisiones estratégicas en la empresa, que resultaron en un ahorro operativo del 20%. Formación Académica Licenciatura en Contaduría Pública Universidad Nacional Autónoma de México (UNAM) 2010 - 2014 Certificación en Auditoría Financiera Instituto Mexicano de Contadores Públicos (IMCP) 2018 Habilidades Software: SAP, QuickBooks, Contpaq, Microsoft Excel avanzado, SQL. Idiomas: Español (nativo), Inglés (avanzado). Competencias: Liderazgo de equipo, resolución de problemas, comunicación efectiva, cumplimiento normativo. Cursos y Certificaciones Curso de Finanzas Corporativas – Coursera, 2019 Certificación en Impuestos Internacionales – Tax Academy, 2021" 

# Asegurarse de que se pase un argumento
if len(sys.argv) < 2:
    print("Error: Se espera un argumento de texto.")
    sys.exit(1)
    
# Obtener el texto pasado como argumento
new_text = sys.argv[1]

# Imprimir predicción y coincidencias encontradas
# print(f"Predicción de carrera para el texto ingresado: {prediction}")
# print(f"Coincidencias encontradas: {', '.join(matches) if matches else 'Ninguna'}")
response = get_prediction_and_matches(new_text)
print(response)

