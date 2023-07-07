<template>
    <input class="w-full text-white p-2 rounded bg-secondary" type="text" :placeholder="props.label"
        :value="props.modelValue" v-on:input="updateValue($event.target.value)" />
</template>
  
<script setup>

const props = defineProps({
    modelValue: ''
})

const emit = defineEmits(['update:modelValue'])

function updateValue(value) {
    emit('update:modelValue', value)
}
</script>