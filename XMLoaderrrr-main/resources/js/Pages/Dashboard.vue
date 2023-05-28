<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                    
                  
                    <div class="text-center">
                        <v-btn
                        color="primary"
                        >
                        Open Dialog

                        <v-dialog
                            v-model="dialog"
                            activator="parent"
                            width="auto"
                        >
                            <v-card>
                            <v-card-text>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </v-card-text>
                            <v-card-actions>
                                <v-btn color="primary" block @click="dialog = false">Close Dialog</v-btn>
                            </v-card-actions>
                            </v-card>
                        </v-dialog>
                        </v-btn>
                    </div>
                    
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