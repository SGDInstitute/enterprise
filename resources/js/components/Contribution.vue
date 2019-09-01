<template>
    <div>
        <div class="p-4 flex flex-col h-full relative">
            <div class="flex-grow relative">
                <div v-if="contribution">
                    <h2 class="font-semibold text-gray-700 text-lg mb-2">{{ contribution.title || '' }}</h2>
                    <p class="font-semibold text-mint-800 tracking-wide text-4xl flex items-center">
                        <span class="text-2xl text-gray-700 font-normal">$</span>
                        {{ contribution.amount/100 }}
                        <span v-if="contribution.type === 'sponsor'" class="text-2xl text-gray-700 font-normal">+</span>
                    </p>
                    <div class="mt-4 trix-content text-gray-800" v-html="contribution.description"></div>
                </div>
                <slot></slot>
            </div>
            <button class="btn btn-gray justify-end mt-4 relative" @click="$emit('select', contribution)" :disabled="disabled"><slot name="button">Select</slot></button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['contribution', 'disabled'],
    }
</script>

<style>
    .trix-content div br {
        display: none;
    }

    .trix-content ul {
        list-style: disc;
        margin-left: 20px;
    }
</style>