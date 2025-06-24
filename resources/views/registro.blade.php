<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Registro de Empleados</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://unpkg.com/alpinejs" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100 p-6">

        <h1 class="text-3xl font-bold text-blue-600 mb-6">Registro de Empleados</h1>

        <div x-data="{
            dataForm: {
                primerNombre: '',
                otrosNombres: '',
                primerApellido: '',
                segundoApellido: '',
                paisEmpleo: '',
                tipoIdentificacion: '',
                identificacion: '',
                correo: '',
                fechaIngreso: '',
                area: '',
                estado: 'Activo',
                fechaHoraRegistro: ''
            },
            correosExistentes: [
                'juan.perez.12345@cidenet.com.co',
                'juan.perez.12345.1@cidenet.com.co'
            ],
            mensajeCorreo: '',
            generarCorreo() {
                if (this.dataForm.primerNombre && this.dataForm.primerApellido && this.dataForm.identificacion && this.dataForm.paisEmpleo) {
                    const dominio = this.dataForm.paisEmpleo === 'Colombia' ? 'cidenet.com.co' :
                        this.dataForm.paisEmpleo === 'Estados Unidos' ? 'cidenet.com.us' : '';
        
                    let baseCorreo = `${this.dataForm.primerNombre.toLowerCase()}.${this.dataForm.primerApellido.toLowerCase()}.${this.dataForm.identificacion}`;
                    let correoGenerado = `${baseCorreo}@${dominio}`;
                    let contador = 1;
        
                    while (this.correosExistentes.includes(correoGenerado)) {
                        correoGenerado = `${baseCorreo}.${contador}@${dominio}`;
                        contador++;
                    }
        
                    if (correoGenerado.length <= 300 && /^[a-z0-9.]+@[a-z]+\.(com\.co|com\.us)$/i.test(correoGenerado)) {
                        this.dataForm.correo = correoGenerado;
                        this.mensajeCorreo = 'Correo generado correctamente.';
                    } else {
                        this.dataForm.correo = '';
                        this.mensajeCorreo = 'Error en el formato del correo generado.';
                    }
                } else {
                    this.mensajeCorreo = 'Complete los campos requeridos para generar el correo.';
                }
            },
            generarFechaHoraRegistro() {
                const now = new Date();
                const pad = n => n.toString().padStart(2, '0');
                this.dataForm.fechaHoraRegistro = `${pad(now.getDate())}/${pad(now.getMonth() + 1)}/${now.getFullYear()} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
            },
            guardarEmpleado() {
                fetch('/empleados', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        },
                        body: JSON.stringify(this.dataForm)
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            console.error(data.errors);
                            alert('Error al registrar el empleado. Verifique los campos.');
                        } else {
                            alert('Empleado registrado correctamente');
                            // Resetear formulario
                            this.dataForm = {
                                primerNombre: '',
                                otrosNombres: '',
                                primerApellido: '',
                                segundoApellido: '',
                                paisEmpleo: '',
                                tipoIdentificacion: '',
                                identificacion: '',
                                correo: '',
                                fechaIngreso: '',
                                area: '',
                                estado: 'Activo',
                                fechaHoraRegistro: ''
                            };
                            this.generarFechaHoraRegistro();
                            this.mensajeCorreo = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error al enviar la información.');
                    });
            }
        }" x-init="generarFechaHoraRegistro()">

            <!-- Primer Apellido -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Primer Apellido</label>
                <input type="text" x-model="dataForm.primerApellido"
                    x-on:input="dataForm.primerApellido = dataForm.primerApellido.replace(/[^a-zA-Z\s]/g, '').slice(0, 20)"
                    class="w-full p-2 border rounded" required />
            </div>

            <!-- Segundo Apellido -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Segundo Apellido</label>
                <input type="text" x-model="dataForm.segundoApellido"
                    x-on:input="dataForm.segundoApellido = dataForm.segundoApellido.replace(/[^a-zA-Z\s]/g, '').slice(0, 20)"
                    class="w-full p-2 border rounded" required />
            </div>

            <!-- Primer Nombre -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Primer Nombre</label>
                <input type="text" x-model="dataForm.primerNombre"
                    x-on:input="dataForm.primerNombre = dataForm.primerNombre.replace(/[^a-zA-Z\s]/g, '').slice(0, 20)"
                    class="w-full p-2 border rounded" required />
            </div>

            <!-- Otros Nombres -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Otros Nombres</label>
                <input type="text" x-model="dataForm.otrosNombres"
                    x-on:input="dataForm.otrosNombres = dataForm.otrosNombres.replace(/[^a-zA-Z\s]/g, '').slice(0, 50)"
                    class="w-full p-2 border rounded" required />
            </div>

            <!-- País de Empleo -->
            <div class="mb-4">
                <label class="block text-sm font-medium">País de Empleo</label>
                <select x-model="dataForm.paisEmpleo" class="w-full p-2 border rounded" required>
                    <option value="">Selecciona un País</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Estados Unidos">Estados Unidos</option>
                </select>
            </div>

            <!-- Tipo de Identificación -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Tipo de Identificación</label>
                <select x-model="dataForm.tipoIdentificacion" class="w-full p-2 border rounded" required>
                    <option value="">Seleccione una opción</option>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="CE">Cédula de Extranjería</option>
                    <option value="PA">Pasaporte</option>
                    <option value="PEP">Permiso Especial</option>
                </select>
            </div>

            <!-- Número de Identificación -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Número de Identificación</label>
                <input type="text" x-model="dataForm.identificacion"
                    x-on:input="dataForm.identificacion = dataForm.identificacion.replace(/[^a-zA-Z0-9]/g, '').slice(0, 20)"
                    class="w-full p-2 border rounded" required />
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Correo Electrónico</label>
                <input type="email" x-model="dataForm.correo" class="w-full p-2 border rounded bg-gray-100" readonly>
                <div x-text="mensajeCorreo" class="text-sm mt-1 text-red-600"></div>
                <button type="button" @click="generarCorreo()"
                    class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Generar Correo
                </button>
            </div>

            <!-- Fecha de Ingreso -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Fecha de Ingreso</label>
                <input type="date" x-model="dataForm.fechaIngreso" :max="new Date().toISOString().split('T')[0]"
                    :min="new Date(new Date().setMonth(new Date().getMonth() - 1)).toISOString().split('T')[0]"
                    class="w-full p-2 border rounded" required>
            </div>

            <!-- Área -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Área</label>
                <select x-model="dataForm.area" class="w-full p-2 border rounded" required>
                    <option value="">Seleccione un área</option>
                    <option>Administración</option>
                    <option>Financiera</option>
                    <option>Compras</option>
                    <option>Infraestructura</option>
                    <option>Operación</option>
                    <option>Talento Humano</option>
                    <option>Servicios Varios</option>
                </select>
            </div>

            <!-- Estado -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Estado</label>
                <input type="text" x-model="dataForm.estado" class="w-full p-2 border rounded bg-gray-100" readonly>
            </div>

            <!-- Fecha y Hora de Registro -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Fecha y Hora de Registro</label>
                <input type="text" x-model="dataForm.fechaHoraRegistro" class="w-full p-2 border rounded bg-gray-100"
                    readonly>
            </div>

            <!-- Botón Guardar -->
            <div class="mb-4">
                <button type="button" @click="guardarEmpleado()"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Guardar Empleado
                </button>
            </div>
        </div>

    </body>

</html>
