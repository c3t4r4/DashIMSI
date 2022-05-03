<template>
    <app-layout title="IMSI">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                IMSI
            </h2>
        </template>

        <div class="py-12">
            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="sm:flex sm:items-center m-4">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Localizados</h1>
                        <input v-model="search" type="text" id="Search" class="mt-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search..." />
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link type="button" :href="route('located')" methods="get" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">Recarregar</Link>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4">
                    <TableModel>
                        <template #header>
                                <tr class="divide-x divide-gray-300">
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">IMSI</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">TIMSI</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Criação</th>
                                    <th v-if="(1==2)" scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pr-6">Ações</th>
                                </tr>
                        </template>

                        <tr v-for="(located, locatedIndex) in locateds" :key="locatedIndex" class="divide-x divide-gray-300" :class="[locatedIndex % 2 !== 0 ? 'bg-gray-50 hover:bg-gray-200' : 'bg-white hover:bg-gray-200']">
                            <td class="whitespace-nowrap text-center py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ located.id }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ located.imsi.imsi }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ located.timsi.timsi }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ located.created_at }}
                            </td>

                            <td v-if="(1==2)" class="whitespace-nowrap text-center py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                <div class="flex justify-center items-center space-x-2">
                                    <TableButton type="show" :route="`users/${located.ID}`" method="get" />
                                    <TableButton type="edit" :route="`users/${located.ID}`" method="post" />
                                    <TableButton type="delete" :route="`users/${located.ID}/destroy`" method="delete" />
                                </div>
                            </td>
                        </tr>

                    </TableModel>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
    import { defineComponent, ref, watch } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    
    import { PlusIcon  } from '@heroicons/vue/solid';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    import TableModel from '@/Components/Tables/TableModel';
    import TableButton from "@/Components/Tables/TableButton";
    import TablePagination from "@/Components/Tables/TablePagination";
    import TableHeader from "@/Components/Tables/TableHeader";

    import { Inertia  } from "@inertiajs/inertia";

    let search = ref('');

    defineProps({ 
        locateds: Object,
    });

    defineComponent({
        AppLayout,
        PlusIcon,
        Head,
        Link,
        TableModel,
        TableButton,
        TablePagination,
        TableHeader
    });

    watch(search, value => {
        Inertia.get("/located", {search:value }, {
            preserveState: true
        });
    });
</script>