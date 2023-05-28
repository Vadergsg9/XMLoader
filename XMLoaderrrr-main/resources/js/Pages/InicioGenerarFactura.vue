<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import GenerarFactura from './comp/GenerarFactura.vue';
</script>

<template>
    <AppLayout title="Descarga Masiva">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Facturar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
                <div class="bg-white overflow-hidden shadow-xl md:rounded-lg">
                    <GenerarFactura />                   
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
  export default {
    data() {
        return {
            dialog: false,
        };
    },
    components: { GenerarFactura }
}
</script>