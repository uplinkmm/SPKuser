<template lang="">
    <div v-if="loading" class="w-full -mt-2">
        <div
            class="relative w-full h-1 bg-slate-700/30 overflow-hidden rounded"
        >
            <div
                class="absolute inset-y-0 left-0 w-2/3 bg-indigo-500 progress-bar"
            ></div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
<style lang="css">
.progress-bar {
    animation: sweep 2s infinite ease-in-out;
    transform: translateX(-100%);
}

@keyframes sweep {
    0% {
        transform: translateX(-100%);
    }
    50% {
        transform: translateX(60%);
    }
    100% {
        transform: translateX(220%);
    }
}
</style>
