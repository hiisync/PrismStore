<template>
    <transition enter-active-class="duration-300 ease-out" enter-from-class="transform opacity-0 -translate-y-full"
        enter-to-class="opacity-100 translate-y-0" leave-active-class="duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0" leave-to-class="transform opacity-0 -translate-y-full">
        <div class="modal fixed inset-0 z-50 overflow-hidden flex items-center justify-center" v-if="showModal">
            <div @click="closeModal" class="modal-background fixed inset-0 bg-gray-900 opacity-50"></div>
            <div class="modal-content bg-white rounded-lg px-4 py-6 w-full max-w-md mx-auto z-10 transform"
                style="transform-origin: top;">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">{{ modalTitle }}</h3>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer flex justify-end">
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-800 mr-4 focus:outline-none">
                        {{ cancelButtonText }}
                    </button>
                    <button @click="submitModal"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none">
                        {{ submitButtonText }}
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
  
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        showModal: {
            type: Boolean,
            required: true,
        },
        modalTitle: {
            type: String,
            default: '',
        },
        cancelButtonText: {
            type: String,
            default: 'Cancel',
        },
        submitButtonText: {
            type: String,
            default: 'Submit',
        },
    },
    methods: {
        closeModal(): void {
            this.$emit('close-modal');
        },
        submitModal(): void {
            this.$emit('submit-modal');
        },
    },
});
</script>
  