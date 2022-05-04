<template>
    <app-layout title="IMSIs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                IMSIs
            </h2>
        </template>

        <PageContent>
            
            <PageGridModel>
                <template #headerPage>
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Cenários</h1>
                        <input v-model="search" type="text" id="Search" class="mt-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search..." />
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Novo</button>
                    </div>
                </template>
                
                <TableModel>
                        <template #header>
                                <tr class="divide-x divide-gray-300">
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Descrição</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Lat/Lng</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Inicio</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Termino</th>
                                    <th v-if="(1==2)" scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pr-6">Ações</th>
                                </tr>
                        </template>

                        <tr v-for="(scenery, sceneryIndex) in sceneries" :key="sceneryIndex" class="divide-x divide-gray-300" :class="[sceneryIndex % 2 !== 0 ? 'bg-gray-50 hover:bg-gray-200' : 'bg-white hover:bg-gray-200']">
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
                                {{ located.start }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ located.finish }}
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
                
            </PageGridModel>
        </PageContent>
    </app-layout>
</template>

<script setup>
    import { defineComponent, ref, watch, onMounted, onUnmounted } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    
    import { PlusIcon  } from '@heroicons/vue/solid';
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

    defineComponent({
        AppLayout,
        PlusIcon,
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