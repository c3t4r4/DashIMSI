<template>
    <!-- BEGIN: Table -->
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <slot name="header" />
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <slot/>
        </tbody>
    </table>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({})
</script>
