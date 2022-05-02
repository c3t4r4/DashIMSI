<template>
    <Link v-if="type === 'show'" :href="route" :methods="method" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      <DocumentSearchIconSolid class="h-5 w-5" aria-hidden="true" />
    </Link>

    <Link v-if="type === 'edit'" :href="route" :methods="method" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-yellow-600 hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
      <PencilAltIconSolid class="h-5 w-5" aria-hidden="true" />
    </Link>

    <Link v-if="type === 'delete'" :href="route"  :methods="method" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
      <TrashIconOutline class="h-5 w-5" aria-hidden="true" />
    </Link>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/inertia-vue3'

import {
  DocumentSearchIcon as DocumentSearchIconSolid,
  TrashIcon as TrashIconSolid,
  PencilAltIcon as PencilAltIconSolid } from '@heroicons/vue/solid';
import {
  DocumentSearchIcon as DocumentSearchIconOutline,
  TrashIcon as TrashIconOutline,
  PencilAltIcon as PencilAltIconOutline} from '@heroicons/vue/outline';

export default defineComponent({
    props:{
        type: String,
        route: String,
        method: String,
    },
    components: {
        Link,
        DocumentSearchIconSolid,
        DocumentSearchIconOutline,
        TrashIconSolid,
        TrashIconOutline,
        PencilAltIconSolid,
        PencilAltIconOutline,
    },
});
</script>
