<template>
    <transition name="fade">
        <div class="popup-overlay" v-if="visible" @click.self="closePopup">
            <transition name="slide-fade">
                <div class="popup-container" v-if="visible">
                    <div class="popup-header">
                        <h2>{{ cliente.nombre }}</h2>
                    </div>
                    <div class="tabs">
                        <button
                            class="tab-button"
                            :class="{ active: activeTab === 'datos' }"
                            @click="activeTab = 'datos'"
                        >
                            Datos Personales
                        </button>
                        <button
                            class="tab-button"
                            :class="{ active: activeTab === 'contacto' }"
                            @click="activeTab = 'contacto'"
                        >
                            Contacto
                        </button>
                        <button
                            class="tab-button"
                            :class="{ active: activeTab === 'acceso' }"
                            @click="activeTab = 'acceso'"
                        >
                            Datos de acceso
                        </button>
                    </div>

                    <div class="popup-content">
                        <!-- Datos Personales -->
                        <div
                            v-if="activeTab === 'datos'"
                            class="tab-content data"
                        >
                            <div class="form-inputs">
                                <div class="form-group">
                                    <label>Nombre Empresa:</label>
                                    <input
                                        type="text"
                                        v-model="cliente.client_name"
                                        disabled
                                    />
                                </div>

                                <div class="form-group">
                                    <label>RUC:</label>
                                    <input
                                        type="text"
                                        v-model="cliente.ruc"
                                        disabled
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Telefono:</label>
                                    <input
                                        type="text"
                                        v-model="cliente.phone"
                                        disabled
                                    />
                                </div>

                                <div class="form-group">
                                    <label>Correo:</label>
                                    <input
                                        type="email"
                                        v-model="cliente.email"
                                        disabled
                                    />
                                </div>

                                <div class="space"></div>

                                <div class="form-group">
                                    <label>Foto de Perfil:</label>
                                    <div class="photo-upload-container">
                                        <div
                                            class="preview-container"
                                            v-if="previewImage"
                                        >
                                            <img
                                                :src="previewImage"
                                                alt="Vista previa"
                                                class="preview-image"
                                            />
                                            <button
                                                type="button"
                                                class="remove-image"
                                                @click="removeImage"
                                            >
                                                ×
                                            </button>
                                        </div>
                                        <div class="file-upload">
                                            <input
                                                type="file"
                                                ref="fileInput"
                                                @change="handleFileUpload"
                                                accept="image/*"
                                                class="file-input"
                                                id="profilePhotoInput"
                                            />
                                            <label
                                                for="profilePhotoInput"
                                                class="file-button"
                                            >
                                                Seleccionar Archivo
                                                <span class="file-icon">
                                                    <i class="pi pi-upload"></i>
                                                </span>
                                            </label>
                                            <span
                                                v-if="selectedFileName"
                                                class="file-name"
                                                >{{ selectedFileName }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Contactos de referencia:</label>
                                <div class="contactos-tabla">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Rol</th>
                                                <th>Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    contacto, index
                                                ) in cliente.contactos"
                                                :key="index"
                                            >
                                                <td>{{ contacto.name }}</td>
                                                <td>
                                                    {{ contacto.address }}
                                                </td>
                                                <td>{{ contacto.email }}</td>
                                                <td>{{ contacto.phone }}</td>
                                                <td>{{ contacto.area }}</td>
                                                <td>
                                                    <input
                                                        type="checkbox"
                                                        v-model="
                                                            contacto.seleccionado
                                                        "
                                                    />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Contacto -->
                        <div
                            v-if="activeTab === 'contacto'"
                            class="tab-content"
                        >
                            <div class="form-group">
                                <label>Contactos de referencia:</label>
                                <div class="contactos-tabla">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Rol</th>
                                                <th>Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    contacto, index
                                                ) in cliente.contactos"
                                                :key="index"
                                            >
                                                <td>{{ contacto.name }}</td>
                                                <td>
                                                    {{ contacto.address }}
                                                </td>
                                                <td>{{ contacto.email }}</td>
                                                <td>{{ contacto.phone }}</td>
                                                <td>{{ contacto.area }}</td>
                                                <td>
                                                    <input
                                                        type="checkbox"
                                                        v-model="
                                                            contacto.seleccionado
                                                        "
                                                    />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Datos de acceso -->
                        <div
                            v-if="activeTab === 'acceso'"
                            class="tab-content access"
                        >
                            <div class="access-form">
                                <div class="form-group">
                                    <label>Correo:</label>
                                    <input
                                        type="email"
                                        v-model="cliente.correo"
                                        disabled
                                    />
                                </div>

                                <div class="form-group">
                                    <label>Contraseña:</label>
                                    <input
                                        type="password"
                                        v-model="cliente.password"
                                        disabled
                                    />
                                </div>
                            </div>

                            <button class="back-pop" @click="closePopup">
                                Volver
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
            </div>
        </transition>
    </template>

<script>
import axios from "axios";

export default {
    name: "PopCompany",
    props: {
        visible: {
            type: Boolean,
            default: false,
        },
        clienteId: {
            type: [String, Number],
            default: null,
        },
    },
    data() {
        return {
            activeTab: "datos",
            cliente: {
                client_name: "Ana Corte",
                nombreCompleto: "Ana Maria Cortez",
                dni: "876567",
                telefono: "98765432",
                correo: "asdy@gmail.com",
                password: "123456",
                contactos: [
                    {
                        nombre: "Aaaaa",
                        direccion: "Av. ffffff",
                        email: "tttt@gmail.com",
                        telefono: "9123221345",
                        rol: "Atencion Cliente",
                        seleccionado: true,
                    },
                    {
                        nombre: "Carlos daniel",
                        direccion: "Av. Mexico con la union dptm 1405",
                        email: "@@gmail.com",
                        telefono: "987654321",
                        rol: "Administracion",
                        seleccionado: true,
                    },
                ],
            },
            selectedFile: null,
            selectedFileName: "",
            previewImage: null,
        };
    },
    methods: {
        closePopup() {
            this.$emit("close");
        },
        loadClienteData() {
            console.log("Cargando datos para cliente ID:", this.clienteId);

            axios.get(`/api/company/${this.clienteId}`)
                .then(response => {
                    console.log("Respuesta de la API:", response.data);
                    this.cliente = response.data;
                    if (!this.cliente.contactos) {
                        this.cliente.contactos = [];
                    }
                     console.log(this.cliente);
                    console.log("------849894965656565");

                    // Si tiene foto, mostrarla
                    if (this.cliente.fotoPerfil) {
                        this.previewImage = this.cliente.fotoPerfil;
                    }
                    return axios.get(`/api/companies/${this.clienteId}/contactos`);
                })
                .then(response => {
                    // Asignar contactos a cliente.contactos
                    this.cliente.contactos = response.data || [];
                })
                .catch(error => {
                    console.error("Error al cargar los datos del cliente:", error);
                });
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validar que sea una imagen
            if (!file.type.match("image.*")) {
                alert("Por favor, selecciona un archivo de imagen válido");
                return;
            }

            this.selectedFile = file;
            this.selectedFileName = file.name;

            // Generar vista previa de la imagen
            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewImage = e.target.result;
                // Aquí podrías guardar también en el objeto cliente
                this.cliente.fotoPerfil = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage() {
            this.previewImage = null;
            this.selectedFile = null;
            this.selectedFileName = "";
            this.cliente.fotoPerfil = null;
            // Limpiar el input file
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = "";
            }
        },
    },
    watch: {
        clienteId: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.loadClienteData();
                }
            },
        },
    },
};
</script>

<style scoped>
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup-container {
    background-color: white;
    border-radius: 8px;
    width: 800px;
    max-width: 90%;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.popup-header {
    background-color: #ffdb99;
    padding: 15px 20px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.popup-header h2 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.tabs {
    display: flex;
    background-color: #f1f1f1;
}

.tab-button {
    flex: 1;
    padding: 12px;
    background-color: #f1f1f1;
    border: none;
    outline: none;
    cursor: pointer;
    transition: 0.3s;
    font-size: 14px;
}

.tab-button.active {
    background-color: #ffb347;
    color: white;
}

.popup-content {
    padding: 20px;
    background-color: #e6e6e6;
}

.tab-content {
    animation: fadeEffect 1s;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: var(--highlight-color);
}

.contactos-tabla {
    max-height: 200px;
    overflow-y: auto;
    margin-top: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 12px;
}

table th {
    background-color: #f2f2f2;
}

.file-icon {
    margin-left: 10px;
}

/* Estilos para la subida de foto */
.photo-upload-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.file-upload {
    display: flex;
    align-items: center;
    gap: 10px;
}

.file-input {
    display: none;
}

.file-upload label {
    padding: 8px 12px;
    background-color: var(--highlight-color);
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.2s ease-in-out;
    margin: 0;
    font-size: 0.8rem;
    text-wrap: nowrap;
    font-weight: normal;
}

.file-button:hover {
    opacity: 0.7;
}

.file-icon {
    display: inline-flex;
}

.file-name {
    color: #666;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.preview-container {
    position: relative;
    width: 100px;
    height: 100px;
    margin-bottom: 10px;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.remove-image {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 22px;
    height: 22px;
    background-color: #ff4d4f;
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    line-height: 1;
    padding: 0;
    transition: 0.2s ease-in-out;
}

.remove-image:hover {
    background-color: #ff7875;
}

.form-inputs {
    display: grid;
    align-items: center;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 0 30px;
}

.access-form {
    display: flex;
    gap: 20px;
}

.back-pop {
    padding: 8px 20px;
    background-color: var(--main-color);
    border-radius: 6px;
    color: white;
}

@keyframes fadeEffect {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Transiciones para el popup */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>
