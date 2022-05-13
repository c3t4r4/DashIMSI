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
                </template>
                
                <TableModel>
                        <template #header>
                                <tr class="divide-x divide-gray-300">
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Descrição</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Lat/Lng</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Inicio</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">Data Termino</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-center text-sm font-semibold text-gray-900 sm:pr-6">Ações</th>
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
                                {{ scenery.start }}
                            </td>

                            <td class="whitespace-nowrap text-center p-4 text-sm text-gray-500">
                                {{ scenery.finish }}
                            </td>

                            <td class="whitespace-nowrap text-center py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">
                                <div class="flex justify-center items-center space-x-2">
                                    <TableButton type="show" :route="`scenery/${scenery.id}`" method="get" />
                                    <TableButton type="edit" :route="`scenery/${scenery.id}`" method="post" />
                                    <TableButton type="delete" :route="`scenery/${scenery.id}`" method="delete" />

                                    <Link v-if="!scenery.finish" :href="`scenery/${scenery.id}/finish`" method="patch" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-stone-600 hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-stone-500" title="Encerrar Cenário">
                                        <LockClosedIcon class="h-5 w-5" aria-hidden="true" />
                                    </Link>

                                    <Link v-else :href="`scenery/${scenery.id}/renew`" method="patch" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-stone-600 hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-stone-500" title="Reabrir Cenário">
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