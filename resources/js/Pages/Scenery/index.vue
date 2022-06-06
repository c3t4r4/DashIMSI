<template>
    <app-layout title="Cenários">
        <template #header>
        </template>

        <PageContent>
            
            <PageGridModel>
                <template #headerPage>
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Cenários</h1>
                        <input v-model="search" type="text" id="Search" class="mt-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Busca..." />
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link as="button" :href="route('scenery.create')" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Novo</Link>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link v-if="selectedPeople.length > 1" as="button" :href="route('scenery.compare')" method="post" :data="selectedPeople" class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">Comparar</Link>
                    </div>
                </template>
                
                <TableModel>
                        <template #header>
                                <tr class="divide-x divide-gray-300">
                                    <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                                        <input type="checkbox" class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6" disabled="disabled" />
                                    </th>
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Descrição</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Lat/Lng</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Inicio</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Termino</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pr-6">Ações</th>
                                </tr>
                        </template>

                        <tr v-for="(scenery, sceneryIndex) in sceneries" :key="sceneryIndex" class="divide-x divide-gray-300" :class="[sceneryIndex % 2 !== 0 ? 'bg-gray-50 hover:bg-gray-200' : 'bg-white hover:bg-gray-200']">
                            <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                <div v-if="selectedPeople.includes(scenery.id)" class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>
                                <input type="checkbox" class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6" :value="scenery.id" v-model="selectedPeople" />
                            </td>
                            <td class="whitespace-nowrap text-center py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ scenery.id }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ scenery.description }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ scenery.lat }} / {{ scenery.lng }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ scenery.lc_start }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ scenery.lc_finish }}
                            </td>

                            <td class="whitespace-nowrap text-center py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                <div class="flex justify-center items-center space-x-2">
                                    <TableButton :id="`show-${scenery.id}`" type="show" :route="`scenery/${scenery.id}`" method="get" />
                                    <TableButton :id="`edit-${scenery.id}`" type="edit" :route="`scenery/${scenery.id}/edit`" method="get" />
                                    <TableButton :id="`delete-${scenery.id}`" type="delete" :route="`scenery/${scenery.id}`" method="delete" />

                                    <Link v-if="!scenery.finish" :id="`closed-${scenery.id}`" :href="`scenery/${scenery.id}/finish`" method="patch" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-stone-600 hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-stone-500" title="Encerrar Cenário">
                                        <LockClosedIcon class="h-5 w-5" aria-hidden="true" />
                                    </Link>

                                    <Link v-else :id="`open-${scenery.id}`" :href="`scenery/${scenery.id}/renew`" method="patch" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-stone-600 hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-stone-500" title="Reabrir Cenário">
                                        <LockOpenIcon class="h-5 w-5" aria-hidden="true" />
                                    </Link>


                                    
                                </div>
                            </td>
                        </tr>

                    </TableModel>
                
            </PageGridModel>
        </PageContent>
    </app-layout>
</template>

<script setup>
    import { defineComponent, ref, watch, onMounted, onUnmounted } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    
    import { PlusIcon, LockClosedIcon, LockOpenIcon  } from '@heroicons/vue/solid';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    import PageContent from '@/Components/PagesContents/PageContent';
    import PageGridModel from '@/Components/PagesContents/PageGridModel';

    import TableModel from '@/Components/Tables/TableModel';
    import TableButton from "@/Components/Tables/TableButton";
    import TablePagination from "@/Components/Tables/TablePagination";
    import TableHeader from "@/Components/Tables/TableHeader";

    import { Inertia  } from "@inertiajs/inertia";

    import debounce from "lodash/debounce";

    let search = ref(props.search);

    let props = defineProps({ 
        sceneries: Object
    });

    const selectedPeople = ref([])

    defineComponent({
        AppLayout,
        PlusIcon,
        LockClosedIcon,
        LockOpenIcon,
        Head,
        Link,
        PageContent,
        PageGridModel,
        TableModel,
        TableButton,
        TablePagination,
        TableHeader
    });

    watch(search, debounce(function (value) {
        Inertia.get("/scenery", {search:value }, {
            preserveState: true
        });
    }, 300));
</script>