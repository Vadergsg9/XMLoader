<template>
  <v-app>
    <v-main>
      <v-container>
        <v-row justify="center">
          <v-col cols="12">
            <v-card>
              <v-card-title class="text-center">
                Acceso por eFirma
              </v-card-title>
              <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
                  <v-file-input
                    v-model="certificado"
                    label="Certificado (.cer)"
                    :rules="certificadoRules"
                    required
                    outlined
                    accept=".cer"
                  ></v-file-input>
                  <v-file-input
                    v-model="clavePrivada"
                    label="Clave privada (.key)"
                    :rules="clavePrivadaRules"
                    required
                    outlined
                    accept=".key"
                  ></v-file-input>
                  <v-text-field
                    v-model="password"
                    label="Contraseña de clave privada"
                    type="password"
                    :rules="passwordRules"
                    required
                    outlined
                  ></v-text-field>
                  <v-text-field
                    v-model="rfc"
                    label="RFC"
                    :rules="rfcRules"
                    required
                    outlined
                  ></v-text-field>

                  <v-text-field
                    v-model="fechaInicial"
                    label="Fecha inicial"
                    type="date"
                    outlined
                  ></v-text-field>

                  <v-text-field
                    v-model="fechaFinal"
                    label="Fecha final"
                    type="date"
                    outlined
                  ></v-text-field>

                  <v-select
                    v-model="tipoSolicitud"
                    :items="['CFDI', 'Metadata']"
                    label="Tipo de solicitud"
                    required
                    outlined
                  ></v-select>

                  <v-select
                    v-model="tipoConsulta"
                    :items="['Emitidos', 'Recibidos']"
                    label="Tipo de consulta"
                    required
                    outlined
                  ></v-select>

                  <v-btn
                    color="primary"
                    class="mr-4"
                    @click="submit"
                    :disabled="!valid || isLoading"
                  >
                    <v-progress-circular indeterminate v-if="isLoading" size="24" />
                    <span v-else>Enviar</span>
                  </v-btn>
                </v-form>
                <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
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
  data: () => ({
    certificado: '',
    clavePrivada: '',
    password: '',
    rfc: '',
    fechaInicial: '',
    fechaFinal: '',
    tipoSolicitud: '',
    tipoConsulta: '',
    valid: false,
    isLoading: false,
    errorMessage: null,
    certificadoRules: [], // Define tus reglas aquí
    clavePrivadaRules: [], // Define tus reglas aquí
    passwordRules: [], // Define tus reglas aquí
    rfcRules: [], // Define tus reglas aquí
  }),
  computed: {
    fechaInicialFormat() {
      return this.fechaInicial ? this.fechaInicial + 'T00:00:00' : '';
    },
    fechaFinalFormat() {
      return this.fechaFinal ? this.fechaFinal + 'T00:59:59' : '';
    },
  },
  methods: {
    async submit() {
      try {
        if (!this.certificado[0] instanceof File) {
          this.showError('No se seleccionó ningún certificado');
          return;
        }

        if (!this.clavePrivada[0] instanceof File) {
          this.showError('No se seleccionó ninguna clave privada');
          return;
        }

        let formData = new FormData();

        formData.append('certificado', await this.readFile(this.certificado[0]));
        formData.append('clavePrivada', await this.readFile(this.clavePrivada[0]));
        formData.append('password', this.password);
        formData.append('rfc', this.rfc);
        formData.append('fechaInicial', this.fechaInicialFormat);
        formData.append('fechaFinal', this.fechaFinalFormat);
        formData.append('tipoSolicitud', this.tipoSolicitud);
        formData.append('tipoConsulta', this.tipoConsulta);

        this.isLoading = true;
        this.errorMessage = null;

        axios.post('descargafactura', formData)
          .then(response => {
            // Maneja la respuesta aquí
            console.log(response);
            // Puedes mostrar un mensaje de éxito o realizar alguna acción en función de la respuesta aquí.
          })
          .catch(error => {
            // Maneja el error aquí
            console.error(error);
            this.errorMessage = error.message || 'Ocurrió un error al enviar el formulario';
          })
          .finally(() => {
            this.isLoading = false;
          });
      } catch (error) {
        console.error(error);
        this.errorMessage = 'Ocurrió un error inesperado';
      }
    },
    readFile(file) {
      return new Promise((resolve, reject) => {
        if (!file) {
          reject('No se seleccionó ningún archivo');
          return;
        }

        if (!(file instanceof Blob)) {
          reject('Archivo no válido');
          return;
        }

        let reader = new FileReader();
        reader.onload = () => {
          resolve(reader.result);
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
      });
    },

  },
};
</script>
