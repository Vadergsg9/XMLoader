<template>
  <v-app>
    <v-main>
      <v-container>
        <v-form ref="form" @submit.prevent="submitForm">
          <h2>Datos de la empresa</h2>
          <v-text-field label="Nombre de la empresa" v-model="formData.company" required></v-text-field>
          <v-text-field label="Nombre(s)" v-model="formData.firstName" required></v-text-field>
          <v-text-field label="Apellido(s)" v-model="formData.lastName" required></v-text-field>
          <v-text-field label="Correo electrónico" v-model="formData.email" required></v-text-field>

          <h2>Domicilio</h2>
          <v-text-field label="Calle" v-model="formData.street" required></v-text-field>
          <v-text-field
            label="No. Interior"
            v-model="formData.interiorNo"
            required
            type="number"
          ></v-text-field>
          <v-text-field
            label="No. Exterior"
            v-model="formData.exteriorNo"
            required
            type="number"
          ></v-text-field>
          <v-text-field label="Colonia" v-model="formData.colony" required></v-text-field>
          <v-text-field
            label="Código Postal"
            v-model="formData.zip"
            required
            type="number"
            :rules="[v => (v && v.length == 5) || 'El código postal debe tener 5 caracteres']"
          ></v-text-field>

          <h2>Inquilino</h2>
          <v-text-field label="Tenant ID" v-model="formData.tenantid" required></v-text-field>

          <v-btn type="submit" color="primary">Crear administrador</v-btn>
        </v-form>
        <v-snackbar v-if="successMessageTipo == 1" v-model="snackbar" color="green">
          {{ successMessage }}
          <v-btn text @click="snackbar = false">Cerrar</v-btn>
        </v-snackbar>
        <v-snackbar v-if="successMessageTipo == 0" v-model="snackbar" color="red">
          {{ successMessage }}
          <v-btn text @click="snackbar = false">Cerrar</v-btn>
        </v-snackbar>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      formData: {
        company: '',
        firstName: '',
        lastName: '',
        email: '',
        street: '',
        interiorNo: '',
        exteriorNo: '',
        colony: '',
        zip: '',
        tenantid: '',
      },
      errorMessage: '',
      successMessage: '',
      successMessageTipo: null,
      snackbar: false,
    };
  },
  methods: {
    submitForm() {
      let ruta = 'agregartenant';
      axios
        .post(ruta, this.formData)
        .then((response) => {
          this.successMessage = response.data.message;
          this.successMessageTipo = response.data.tipo;
          this.snackbar = true;
          this.errorMessage = '';
        })
        .catch((error) => {
          if (error.response.status === 409) {
            this.errorMessage = error.response.data.message;
            this.successMessageTipo = response.data.tipo;
          }
        });
    },
  },
};
</script>
