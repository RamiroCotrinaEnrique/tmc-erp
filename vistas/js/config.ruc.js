/**
 * CONFIGURACIÓN - Consulta Automática de RUC
 * 
 * Este archivo contiene la configuración centralizada para la integración
 * de consultas de RUC con APISPERU. Se puede usar en futuras mejoras.
 */

// ============================================
// API APISPERU CONFIGURATION
// ============================================

const CONFIG_RUC = {
    // Configuración del API
    api: {
        // URL base del API
        baseUrl: 'https://dniruc.apisperu.com/api/v1',
        
        // Endpoints
        endpoints: {
            ruc: '/ruc/:ruc',           // Obtener datos por RUC
            dni: '/dni/:dni'            // Obtener datos por DNI (futuro)
        },
        
        // Token de autenticación
        token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNvdHJpbmFyYW1pcm9AZ21haWwuY29tIn0.uPGK2zSx7XlSQYNLaOjjJ6IP6QPUR5kV4QDwC9yjDJA',
        
        // Timeout en segundos
        timeout: 10,
        
        // Reintentos
        retries: 1,
        
        // Delay entre reintentos (ms)
        retryDelay: 1000
    },
    
    // Configuración de validación
    validation: {
        // Longitud de RUC
        rucLength: 11,
        
        // Validar que sea numérico
        numericOnly: true,
        
        // Mensaje de validación
        messages: {
            required: 'El RUC es requerido',
            length: 'El RUC debe tener 11 dígitos',
            numeric: 'El RUC debe contener solo números',
            invalid: 'RUC no encontrado o inválido',
            notFound: 'No se encontró información para este RUC',
            apiError: 'Error al consultar el RUC. Intente rellenar los datos manualmente.',
            connectionError: 'No se pudo conectar con el API de APISPERU'
        }
    },
    
    // Configuración de UI
    ui: {
        // Mostrar/ocultar indicador de carga
        showLoader: true,
        
        // Mostrar/ocultar notificaciones
        showNotifications: true,
        
        // Tipo de notificación (swal, toast, alert)
        notificationType: 'swal',
        
        // Animación de carga
        loaderAnimation: 'spinner',  // 'spinner', 'pulse', 'dots'
        
        // Delays en ms
        delays: {
            loader: 300,          // Mostrar loader después de X ms
            notification: 1500    // Ocultar notificación después de X ms
        }
    },
    
    // Campos a mapear
    fieldMapping: {
        // Agregar Empresa
        agregar: {
            ruc: 'inputRuc',
            razonSocial: 'inputRazonSocial',
            nombreComercial: 'inputNombreComercial',
            domicilio: 'inputDomicilioLegal',
            contacto: 'inputNumeroContacto',
            email: 'inputEmail'
        },
        
        // Editar Empresa
        editar: {
            ruc: 'inputEditRuc',
            razonSocial: 'inputEditRazonSocial',
            nombreComercial: 'inputEditNombreComercial',
            domicilio: 'inputEditDomicilioLegal',
            contacto: 'inputEditNumeroContacto',
            email: 'inputEditEmail'
        }
    },
    
    // Caché de consultas (futuro)
    cache: {
        enabled: false,
        ttl: 3600,  // 1 hora en segundos
        storage: 'localStorage'  // 'localStorage' o 'sessionStorage'
    },
    
    // RUCs de prueba
    testRucs: [
        {
            ruc: '20131312955',
            empresa: 'REPARTO PERU S.A.C.'
        },
        {
            ruc: '20369157099',
            empresa: 'TELEFONICA DEL PERU S.A.A.'
        },
        {
            ruc: '20500000035',
            empresa: 'EMPRESA NACIONAL DE ELECTRICIDAD S.A.'
        }
    ],
    
    // Formato de respuesta esperada
    responseFormat: {
        success: true,
        ruc: '',
        razonSocial: '',
        nombreComercial: '',
        telefonos: [],
        domicilio: '',
        distrito: '',
        provincia: '',
        departamento: '',
        direccion: ''
    },
    
    // Eventos personalizados
    events: {
        // Antes de consultar
        onBeforeConsult: function(ruc) {
            console.log('Consultando RUC:', ruc);
        },
        
        // Después de consultar exitosamente
        onSuccess: function(data) {
            console.log('Datos obtenidos:', data);
        },
        
        // En caso de error
        onError: function(error) {
            console.log('Error:', error);
        },
        
        // Después de llenar los campos
        onFillComplete: function(fields) {
            console.log('Campos llenados:', fields);
        }
    },
    
    // Configuración de logging
    logging: {
        enabled: true,
        level: 'info',  // 'debug', 'info', 'warn', 'error'
        console: true,
        remote: false   // Enviar logs a servidor (futuro)
    }
};

// ============================================
// FUNCIÓN AUXILIAR - Obtener configuración
// ============================================
function getConfig(key, defaultValue = null) {
    const keys = key.split('.');
    let config = CONFIG_RUC;
    
    for (const k of keys) {
        config = config[k];
        if (config === undefined) {
            return defaultValue;
        }
    }
    
    return config;
}

// ============================================
// FUNCIÓN AUXILIAR - Actualizar configuración
// ============================================
function updateConfig(key, value) {
    const keys = key.split('.');
    let config = CONFIG_RUC;
    
    for (let i = 0; i < keys.length - 1; i++) {
        config = config[keys[i]];
    }
    
    config[keys[keys.length - 1]] = value;
}

// ============================================
// EJEMPLO DE USO
// ============================================
/*

// Obtener token
const token = getConfig('api.token');

// Obtener timeout
const timeout = getConfig('api.timeout');

// Obtener campo para agregar empresa
const fieldRuc = getConfig('fieldMapping.agregar.ruc');

// Actualizar timeout
updateConfig('api.timeout', 15);

// Usar evento personalizado
CONFIG_RUC.events.onSuccess(data);

*/
