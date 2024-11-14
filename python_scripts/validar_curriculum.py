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
    {"text": "Contabilidad financiera, balance general, estados financieros", "label": "Contador"},
    {"text": "Bases de datos, SQL Server, MySQL", "label": "Desarrollador"},
    {"text": "Auditoría interna, análisis de riesgos, control financiero", "label": "Contador"},
    {"text": "Backend, Node.js, Express", "label": "Desarrollador"},
    {"text": "Gestión de impuestos, declaraciones fiscales, IVA", "label": "Contador"},
    {"text": "Aplicaciones móviles, Android Studio, Java", "label": "Desarrollador"},
    {"text": "Cálculo de nómina, deducciones, retenciones", "label": "Contador"},
    {"text": "Machine Learning, Python, TensorFlow", "label": "Desarrollador"},
    {"text": "Contabilidad de costos, análisis de costos de producción", "label": "Contador"},
    {"text": "Aplicaciones de escritorio, C++, Visual Studio", "label": "Desarrollador"},
    {"text": "Flujo de caja, proyecciones financieras, conciliaciones bancarias", "label": "Contador"},
    {"text": "PHP, Laravel, bases de datos relacionales", "label": "Desarrollador"},
    {"text": "Contabilidad de activos fijos, depreciación, amortización", "label": "Contador"},
    {"text": "Gestión de APIs, RESTful, JSON", "label": "Desarrollador"},
    {"text": "Control de cuentas por cobrar, cuentas por pagar, gestión de cobros", "label": "Contador"},
    {"text": "Frontend, React, Vue.js", "label": "Desarrollador"},
    {"text": "Preparación de informes financieros mensuales, trimestrales", "label": "Contador"},
    {"text": "Desarrollo ágil, Scrum, Git", "label": "Desarrollador"},
    {"text": "Software contable, QuickBooks, SAP, Contpaqi", "label": "Contador"},
    {"text": "Desarrollo en la nube, AWS, Azure", "label": "Desarrollador"},
    {"text": "Análisis de balances, razon de liquidez, solvencia", "label": "Contador"},
    {"text": "Automatización de pruebas, Selenium, Cypress", "label": "Desarrollador"},
    {"text": "Presupuesto empresarial, planificación financiera, previsión de ingresos", "label": "Contador"},
    {"text": "Ecommerce, Magento, WooCommerce", "label": "Desarrollador"},
    {"text": "Contabilidad fiscal, impuestos sobre la renta, IVA, ISR", "label": "Contador"},
    {"text": "Inteligencia artificial, scikit-learn, NLP", "label": "Desarrollador"},
    {"text": "Conciliación contable, revisión de estados bancarios, ajustes contables", "label": "Contador"},
    {"text": "Desarrollador full-stack, MongoDB, GraphQL", "label": "Desarrollador"},
    {"text": "Normas contables, IFRS, NIIF, normativas fiscales", "label": "Contador"},
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
    "Contador": set()
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
#new_text = ""
# Asegurarse de que se pase un argumento
if len(sys.argv) < 2:
    print("Error: Se espera un argumento de texto.")
    sys.exit(1)
    
# Obtener el texto pasado como argumento
new_text = sys.argv[1]

response = get_prediction_and_matches(new_text)
print(response)

