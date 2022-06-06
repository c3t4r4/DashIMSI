<template>
    <app-layout title="Cenários">
        <template #header>
        </template>

        <PageContent>
            <form @submit.prevent="submit" class="space-y-8 divide-y divide-gray-200">
                <div class="space-y-8 divide-y divide-gray-200">
                    <div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Edição de Cenário - ID: {{ scenery.id }}</h3>
                        </div>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="start" class="block text-sm font-medium text-gray-700"> Data Hora Inicial </label>
                            <div class="mt-1">
                                <input type="datetime-local" v-model="scenery.start_local" id="start" autocomplete="given-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="finish" class="block text-sm font-medium text-gray-700"> Data Hora Final </label>
                            <div class="mt-1">
                                <input type="datetime-local" v-model="scenery.finish_local" id="finish" autocomplete="family-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>

                        <div class="sm:col-span-1">
                            <label for="lat" class="block text-sm font-medium text-gray-700"> Latitude </label>
                            <div class="mt-1">
                                <input v-model="scenery.lat" id="lat" type="number" step="0.0001" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>

                        <div class="sm:col-span-1">
                            <label for="lng" class="block text-sm font-medium text-gray-700"> Longitude </label>
                            <div class="mt-1">
                                <input v-model="scenery.lng" id="lng" type="number" step="0.0001" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700"> Descrição </label>
                            <div class="mt-1">
                                <textarea id="description" v-model="scenery.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" />
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <Link :href="route('scenery.index')" as="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</Link>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Salvar</button>
                    </div>
                </div>
            </form>
        </PageContent>
    </app-layout>
</template>

<script setup>
    import { defineComponent, reactive } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    
    import { PlusIcon  } from '@heroicons/vue/solid';
    import { Inertia } from '@inertiajs/inertia';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    import PageContent from '@/Components/PagesContents/PageContent';

    let props = defineProps({ 
        scenery: Object
    });

    let submit = () => {
        Inertia.put(`/scenery/${props.scenery.id}`, props.scenery);
    }



</script>