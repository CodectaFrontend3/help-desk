<template>
    <div class="another-page">
        <Button
            class="open-dialog-btn"
            label="Mostrar Modal"
            icon="pi pi-user"
            @click="openDialog"
        />

        <Dialog
            v-model:visible="visible"
            header="REGISTRAR CLIENTE"
            class="custom-dialog"
            :closable="false"
            style="
                width: 1000px;
                background-color: aliceblue;
                border-radius: 15px;
            "
        >
            <template #header>
                <div class="custom-dialog-header">
                    <span>Registrar Cliente</span>
                    <button class="close-dialog-btn" @click="closeDialog">
                        ✖
                    </button>
                </div>
            </template>

            <!-- Botones -->
            <ButtonGroup
                :buttons="buttonData"
                :currentView="currentView"
                @updateView="updateCurrentView"
            />

            <!-- FORMULARIO DATOS PERSONALES -->
            <div v-if="currentView === 'datospersonales'" class="form-section">
                <h3>Datos Personales</h3>
                <FormGroup label="Nombre Completo">
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Ej. Juan Pérez"
                    />
                </FormGroup>
                <FormGroup label="DNI">
                    <input
                        type="text"
                        class="form-input"
                        placeholder="12345678"
                    />
                </FormGroup>
                <FormGroup label="Fecha de Nacimiento">
                    <input type="date" class="form-input" />
                </FormGroup>
            </div>

            <!-- FORMULARIO CONTACTO -->
            <div v-if="currentView === 'contacto'" class="form-section">
                <h3>Contacto</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Cargo</th>
                                <th>
                                    <button style="font-size: 15px">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, rowIndex) in rows" :key="rowIndex">
                                <td
                                    v-for="(cell, colIndex) in row"
                                    :key="colIndex"
                                >
                                    <template v-if="colIndex === 5">
                                        <input
                                            type="checkbox"
                                            v-model="row[colIndex]"
                                        />
                                    </template>
                                    <template v-else>
                                        {{ cell }}
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FORMULARIO EMPRESA -->
            <div v-if="currentView === 'empresa'" class="form-section">
                <h3>Datos de la Empresa</h3>
                <FormGroup label="RUC">
                    <input
                        type="text"
                        class="form-input"
                        placeholder="12345678901"
                    />
                </FormGroup>
                <FormGroup label="Razón Social">
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Empresa SAC"
                    />
                </FormGroup>
                <FormGroup label="Departamento">
                    <Dropdown :options="['Lima', 'Arequipa', 'Cusco']" />
                </FormGroup>
                <FormGroup label="Provincia">
                    <Dropdown :options="['Lima', 'Cañete', 'Barranca']" />
                </FormGroup>
                <FormGroup label="Distrito">
                    <Dropdown
                        :options="['Miraflores', 'San Isidro', 'Surco']"
                    />
                </FormGroup>
                <FormGroup label="Dirección Fiscal">
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Av. Principal 123"
                    />
                </FormGroup>
            </div>

            <!-- FORMULARIO FACTURACIÓN -->
            <div v-if="currentView === 'facturacion'" class="form-section">
                <h3>Datos de Facturación</h3>
                <FormGroup label="Tipo de Comprobante">
                    <Dropdown :options="['Boleta', 'Factura']" />
                </FormGroup>
                <FormGroup label="Condición de Pago">
                    <Dropdown :options="['Contado', 'Crédito']" />
                </FormGroup>
                <FormGroup label="Moneda">
                    <Dropdown :options="['Soles', 'Dólares']" />
                </FormGroup>
                <FormGroup label="Observaciones">
                    <textarea
                        class="form-input"
                        placeholder="Notas adicionales..."
                    ></textarea>
                </FormGroup>
            </div>

            <!-- FORMULARIO ACCESO -->
            <div v-if="currentView === 'acceso'" class="form-section">
                <h3>Datos de Acceso</h3>
                <FormGroup label="Correo Electrónico">
                    <input
                        type="email"
                        class="form-input"
                        placeholder="correo@ejemplo.com"
                    />
                </FormGroup>
                <FormGroup label="Nombre de Usuario">
                    <input
                        type="text"
                        class="form-input"
                        placeholder="usuario123"
                    />
                </FormGroup>
                <FormGroup label="Contraseña">
                    <input type="password" class="form-input" />
                </FormGroup>
            </div>

            <!-- BOTÓN DE VOLVER -->
            <button class="close-btn" @click="closeDialog">Volver</button>
        </Dialog>
    </div>
</template>

<script>
import Dialog from "primevue/dialog";
import ButtonGroup from "../Formulario/Assets/ButtonGroup.vue";
import FormGroup from "../Formulario/Assets/FormGroup.vue";
import Button from "primevue/button";
import Dropdown from "../Formulario/Assets/DropDownGroup.vue";

export default {
    name: "tiregistrarcc",
    components: {
        Dialog,
        Button,
        ButtonGroup,
        Dropdown,
        FormGroup,
    },
    data() {
        return {
            visible: false,
            currentView: "datospersonales",
            buttonData: [
                { label: "Datos Personales", value: "datospersonales" },
                { label: "Contacto", value: "contacto" },
                { label: "Empresa", value: "empresa" },
                { label: "Facturación", value: "facturacion" },
                { label: "Datos de acceso", value: "acceso" },
            ],
            rows: [
                [
                    "Juan Pérez",
                    "Calle Falsa 123",
                    "juan@example.com",
                    "555-1234",
                    "Gerente",
                    false,
                ],
                [
                    "Ana Gómez",
                    "Avenida Siempre Viva 742",
                    "ana@example.com",
                    "555-5678",
                    "Secretaria",
                    false,
                ],
                [
                    "Carlos López",
                    "Calle Real 456",
                    "carlos@example.com",
                    "555-8765",
                    "Vendedor",
                    false,
                ],
                [
                    "María Díaz",
                    "Avenida Central 789",
                    "maria@example.com",
                    "555-4321",
                    "Supervisor",
                    false,
                ],
            ],
        };
    },
    methods: {
        openDialog() {
            this.visible = true;
        },
        closeDialog() {
            this.visible = false;
        },
        updateCurrentView(view) {
            this.currentView = view;
        },
    },
};
</script>

<style scoped>
.another-page {
    padding: 20px;
}

.custom-dialog-header {
    background-color: #ffcb87;
    color: black;
    font-size: 25px;
    text-align: center;
    font-weight: bold;
    padding: 10px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border-radius: 15px 15px 0 0;
}

.close-dialog-btn {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 20px;
    color: white;
    cursor: pointer;
}

.close-dialog-btn:hover {
    color: #ff0000;
}

.table-container {
    margin-top: 20px;
    overflow-x: auto;
}

.table-container table {
    width: 90%;
    border-collapse: collapse;
    margin: 0 auto;
}

.table-container th,
.table-container td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    font-size: 14px;
    background-color: #fff;
}

.table-container th {
    background-color: #ffcb87;
    color: #333;
}

.close-btn {
    background-color: #ffcb87;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 15px;
    width: 10%;
}

.close-btn:hover {
    background-color: #ffb049;
}

.form-section {
    margin-top: 20px;
    padding: 0 30px;
}

.form-input {
    padding: 8px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 100%;
}
</style>
