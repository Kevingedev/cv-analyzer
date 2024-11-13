from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import make_pipeline
from sklearn import metrics
import joblib
import re
import json
import sys
import sys
sys.stdout.reconfigure(encoding='utf-8')

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
#new_text = "CARLOS JOSE PEREZ RUIZ EXPERIENCIA DESARROLLADOR WEB FULL STACK Soluciones Digitales S.A. de C.V. San Salvador, El Salvador Agosto 2019 Actualidad CARLOSJOSE.RUIZ@GMAIL.COM 77587985 Desarrollé y mantuve aplicaciones web dinámicas utilizando Laravel para el backend y React en el frontend, asegurando alta eficiencia y escalabilidad en los proyectos. Implementé diseños responsivos para mejorar la experiencia en dispositivos móviles, lo que incrementó la retención de usuarios en un 20. Integré APIs de terceros, como servicios de pago y plataformas de redes sociales, para expandir las capacidades de la plataforma. Colaboré en la implementación de prácticas de seguridad para proteger datos sensibles y prevenir vulnerabilidades de seguridad. DESARROLLADOR FRONTEND Agencia Creativa Web S.A. San Salvador, El Salvador Marzo 2016 Julio 2019 IDIOMAS Español: Nativo Inglés: Intermedio (lectura y escritura técnica) APTITUDES Desarrollador Web Full Stack con más de 5 años de experiencia en el diseño y desarrollo de aplicaciones web innovadoras y centradas en el usuario. Diseñé e implementé interfaces de usuario atractivas y funcionales utilizando HTML, CSS, y JavaScript, asegurando una experiencia de usuario coherente y optimizada. Trabajé con el equipo de diseño para traducir maquetas en experiencias digitales efectivas, cumpliendo con los estándares de accesibilidad y compatibilidad en distintos navegadores. Utilicé Vue.js y JavaScript ES6 para desarrollar componentes reutilizables, mejorando la eficiencia y consistencia del código. Realicé pruebas de usabilidad y optimización de rendimiento, logrando reducir los tiempos de carga en un 30.Asistente Contable ASISTENTE DE DESARROLLO WEB Desarrollos Tecnológicos S.A. San Salvador, El Salvador Mayo 2014 Febrero 2016 Apoyé en el desarrollo y mantenimiento de sitios web en WordPress, realizando personalizaciones y ajustes según los requerimientos del cliente. Colaboré en la creación de plantillas de HTML y CSS, mejorando la velocidad de desarrollo y facilitando la consistencia en los diseños. Realicé pruebas de compatibilidad en navegadores y dispositivos para garantizar una experiencia de usuario fluida. Apoyo con pruebas unitarias para sitios web administrativos. FORMACIÓN ACADÉMICA Licenciatura en Ingeniería en Sistemas Informáticos Universidad de El Salvador Graduación: Diciembre 2013 Certificación en Desarrollo Web Full Stack Academia de Innovación Digital El Salvador 2018 HABILIDADES TÉCNICAS Frontend: HTML5, CSS3, JavaScript (ES6), React, Vue.js, Bootstrap. Backend: PHP, Laravel, Node.js. Bases de Datos: MySQL, MongoDB. Herramientas y Versionamiento: Git, GitHub, Bitbucket. Otras Tecnologías: APIs RESTful, JSON, AJAX. Idiomas: Español (nativo), Inglés (intermedioavanzado). 2" 

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

