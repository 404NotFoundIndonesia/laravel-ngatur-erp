<script setup>
defineProps({
    value: String,
    required: Boolean
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
        <span v-if="value">{{ value }} <span v-if="required" class="text-red-700">*</span></span>
        <span v-else><slot /></span>
    </label>
</template>
