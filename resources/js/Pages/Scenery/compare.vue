<template>
    <app-layout title="Cenários">
        <template #header>
        </template>

        <PageContent>
            
            <PageGridModel>
                <template #headerPage>
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Comparando: Cenários - Valores Únicos</h1>
                        <p class="m-3" v-for="(scenary, scenaryIndex) in scenariesTitle" :key="scenaryIndex">Cenário - ID: {{ scenary.id }} - Descrição: {{ scenary.description }} - Início: {{ scenary.lc_start }} - Fim: {{ scenary.lc_finish }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link as="button" :href="route('scenery.index')" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Voltar</Link>
                    </div>
                </template>
                
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
                                    <TableButton type="show" :route="`users/${located.id}`" method="get" />
                                    <TableButton type="edit" :route="`users/${located.id}`" method="post" />
                                    <TableButton type="delete" :route="`users/${located.id}/destroy`" method="delete" />
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

    import VtrilProgress from "vtril-progress";

    let props = defineProps({ 
        locateds: Object,
        scenariesTitle: Object,
        search: String,
        unique: Boolean
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

    function updateData(){
        VtrilProgress.disable(() => {
            Inertia.reload({ only: ['locateds','scenariesTitle','search', 'unique'], hideProgress: true });
        });
    }

    onUnmounted(() => {
    });
</script>