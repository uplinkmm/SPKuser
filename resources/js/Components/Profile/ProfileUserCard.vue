<template>
    <div class="pt-2 pb-6">
        <div class="grid grid-cols-3 gap-3 text-white font-semibold pl-3">
            <div class="col-span-1 relative">
                <img
                    src="../../../../public/img/profile.png"
                    alt="Profile"
                    class="w-26 h-26 rounded-full"
                />
                <button
                    type="button"
                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                >
                    <i class="fas fa-pen text-xs"></i>
                </button>
            </div>

            <div class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8">
                <div class="flex justify-between items-center gap-x-4">
                    <p>နာမည် :</p>
                    <p>{{ user.name }}</p>
                </div>
                <div class="flex justify-between items-center gap-x-4">
                    <p>ဖုန်းနံပါတ် :</p>
                    <p>{{ user.phone_number }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
