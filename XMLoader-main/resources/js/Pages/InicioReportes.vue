<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MostrarReportes from './comp/MostrarReportes.vue';
</script>

<template>
    <AppLayout title="Descarga Masiva">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reportes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl md:rounded-lg">
                    <MostrarReportes />                   
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
      }
    },
  }
</script>