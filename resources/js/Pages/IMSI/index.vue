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
                        <h1 class="text-xl font-semibold text-gray-900">Localizados</h1>
                        <input v-model="search" type="text" id="Search" class="mt-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search..." />
                    </div>
                    <div class="relative flex items-start mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <div class="flex items-center h-5">
                            <input v-model="unique" id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="comments" class="font-medium text-gray-700">Unique</label>
                        </div>
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

    import VtrilProgress from "vtril-progress";

    let search = ref(props.search);
    let unique = ref(props.unique);

    var interval;

    let props = defineProps({ 
        locateds: Object,
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
            Inertia.reload({ only: ['locateds'], hideProgress: true });
        });
    }

    onMounted(() => {
        interval = setInterval(function () {
            updateData();
          } , 3000);  // set 3000 to any number you need
    });

    onUnmounted(() => {
        clearInterval(interval);
    });

    watch(search, value => {
        Inertia.get("/located", {unique: props.unique, search:value }, {
            preserveState: true
        });
    });

    watch(unique, value => {
        Inertia.get("/located", {unique: value, search:props.search }, {
            preserveState: true
        });
    });
</script>