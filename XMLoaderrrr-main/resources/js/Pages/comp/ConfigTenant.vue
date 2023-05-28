<template>
    <v-app>
      <v-main>
        <v-container>
          <v-form ref="form" @submit.prevent="submitForm">
            <v-text-field
              label="Nombre de empresa"
              v-model="formData.companyName"
              required
            ></v-text-field>
            <v-text-field
              label="Nombre"
              v-model="formData.name"
              required
            ></v-text-field>
            <v-text-field
              label="Apellido"
              v-model="formData.surname"
              required
            ></v-text-field>
            <v-text-field
              label="Correo electrónico"
              v-model="formData.email"
              type="email"
              required
            ></v-text-field>
            <v-text-field
              label="Contraseña"
              v-model="formData.password"
              type="password"
              required
            ></v-text-field>
            <v-text-field
              label="Dominio"
              v-model="formData.domain"
              required
            ></v-text-field>
            
            <h3>Domicilio</h3>
            <v-text-field
              label="Calle"
              v-model="formData.address.street"
              required
            ></v-text-field>
            <v-text-field
              label="No. Interior"
              v-model="formData.address.interiorNumber"
              type="number"
              required
            ></v-text-field>
            <v-text-field
              label="No. Exterior"
              v-model="formData.address.exteriorNumber"
              type="number"
              required
            ></v-text-field>
            <v-text-field
              label="Colonia"
              v-model="formData.address.neighborhood"
              required
            ></v-text-field>
            <v-text-field
              label="Código Postal"
              v-model="formData.address.postalCode"
              type="number"
              maxlength="5"
              counter
              required
            ></v-text-field>
  
            <v-btn type="submit" color="primary">Crear administrador</v-btn>
          </v-form>
        </v-container>
      </v-main>
    </v-app>
  </template>
  
  <script>
  export default {
    data() {
      return {
        formData: {
          companyName: "",
          name: "",
          surname: "",
          email: "",
          password: "",
          domain: "",
          address: {
            street: "",
            interiorNumber: "",
            exteriorNumber: "",
            neighborhood: "",
            postalCode: "",
          },
        },
      };
    },
    methods: {
      submitForm() {
        if (this.$refs.form.validate()) {
          console.log("Formulario válido:", this.formData);
        } else {
          console.log("Formulario inválido");
        }
      },
    },
  };
  </script>
  