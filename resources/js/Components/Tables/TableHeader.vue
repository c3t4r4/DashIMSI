<template>
    <div class="bg-white px-4 sm:px-6 lg:px-8">
        <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ title }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    <slot name="text"/>
                </p>
            </div>
            <div class="ml-4 mt-4 flex-shrink-0">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'


export default defineComponent({
    props: {
        title: {
            default: "",
            type: String
        }
    }
})
</script>
