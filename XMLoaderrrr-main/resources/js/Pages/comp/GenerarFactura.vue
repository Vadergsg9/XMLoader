<template>
    <v-app>
      <v-main>
        <v-container>
          <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
              <v-card>
                <v-card-title class="headline" align="center">
                  Generador de CFDI
                </v-card-title>
                <v-card-text>
                  <h2>Emisor</h2>
                  <v-text-field
                    label="Nombre o Razón Social:"
                    v-model="emisor.nombre"
                    required
                  />
                  <v-textarea
                    label="Dirección:"
                    v-model="emisor.direccion"
                    required
                  />
                  <v-text-field
                    label="Código Postal:"
                    v-model="emisor.cp"
                    required
                  />
                  <v-text-field
                    label="RFC:"
                    v-model="emisor.rfc"
                    required
                  />
                  <v-select
                    :items="regimenesFiscales"
                    item-text="text"
                    item-value="value"
                    label="Régimen Fiscal:"
                    v-model="emisor.regimen"
                    required
                  />
  
                  <h2>Receptor</h2>
                  <v-text-field
                    label="Nombre o Razón Social:"
                    v-model="receptor.nombre"
                    required
                  />
                  <v-textarea
                    label="Dirección:"
                    v-model="receptor.direccion"
                    required
                  />
                  <v-text-field
                    label="Código Postal:"
                    v-model="receptor.cp"
                    required
                  />
                  <v-text-field
                    label="RFC:"
                    v-model="receptor.rfc"
                    required
                  />
                  <v-select
                    :items="regimenesFiscales"
                    item-text="text"
                    item-value="value"
                    label="Régimen Fiscal:"
                    v-model="receptor.regimen"
                    required
                  />
                  <v-select
                    :items="usosCFDI"
                    item-text="text"
                    item-value="value"
                    label="Uso de CFDI:"
                    v-model="receptor.usoCFDI"
                    required
                  />
                  <v-text-field
                    label="Monto:"
                    v-model="monto"
                    type="number"
                    required
                  />
                  <v-btn @click="rescatarCliente" color="primary">Rescatar Cliente</v-btn>
                  <v-btn @click="generarCFDI" color="success">Generar CFDI</v-btn>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
  </template>
  
  <script>
  export default {
    data() {
      return {
        emisor: {
          nombre: "",
          direccion: "",
          cp: "",
          rfc: "",
          regimen: "",
        },
        receptor: {
          nombre: "",
          direccion: "",
          cp: "",
          rfc: "",
          regimen: "",
          usoCFDI: "",
        },
        monto: "",
        regimenesFiscales: [
          { text: "Seleccione", value: "" },
          { text: "General de Ley Personas Morales", value: "601" },
          { text: "Personas Morales con Fines no Lucrativos", value: "603" },
          { text: "Sueldos y Salarios e Ingresos Asimilados a Salarios", value: "605" },
          { text: "Arrendamiento", value: "606" },
        ],
        usosCFDI: [
          { text: "Seleccione", value: "" },
          { text: "Adquisición de mercancías", value: "G01" },
          { text: "Devoluciones, descuentos o bonificaciones", value: "G02" },
          { text: "Gastos en general", value: "G03" },
          { text: "Construcciones", value: "I01" },
        ],
      };
    },
    methods: {
      rescatarCliente() {
        // Aquí puedes agregar tu lógica para rescatar el cliente de la base de datos
        // y rellenar los campos correspondientes
        this.receptor.rfc = "RFC del cliente rescatado";
        this.receptor.nombre = "Nombre del cliente rescatado";
        this.receptor.direccion = "Dirección del cliente rescatado";
        this.receptor.cp = "Código Postal del cliente rescatado";
        this.receptor.regimen = "Régimen Fiscal del cliente rescatado";
        this.receptor.usoCFDI = "Uso de CFDI del cliente rescatado";
      },
      generarCFDI() {
        // Aquí puedes agregar tu lógica para generar el CFDI
        console.log(this.emisor, this.receptor, this.monto);
      },
    },
  };
  </script>
  