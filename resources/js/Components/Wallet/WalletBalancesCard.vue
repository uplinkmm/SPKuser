<template>
    <div class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 py-4">
        <div class="space-y-4 text-black">
            <div class="flex items-center justify-between gap-x-3">
                <div class="flex items-center gap-x-3 min-w-0">
                    <img
                        src="../../../../public/icons/Wallet.png"
                        class="w-11 pl-1"
                    />
                    <p class="font-semibold truncate">ပင်မပိုက်ဆံအိတ်</p>
                    <div
                        :class="[
                            'shrink-0 rounded-full bg-black flex items-center justify-center text-white font-bold',
                            helpBadgeClass,
                        ]"
                    >
                        ?
                    </div>
                </div>
                <p
                    :class="[
                        'font-semibold whitespace-nowrap text-right',
                        amountClass,
                    ]"
                >
                    {{ formatBalance(mainBalance) }} ကျပ်
                </p>
            </div>

            <div class="flex items-center justify-between gap-x-3">
                <div class="flex items-center gap-x-3 min-w-0">
                    <div class="relative w-12 h-9 shrink-0">
                        <img
                            src="../../../../public/icons/Wallet.png"
                            class="w-full h-full object-contain"
                        />
                        <img
                            src="../../../../public/icons/joystick.png"
                            class="absolute left-0 top-3/4 -translate-y-1/2 w-7 h-7 object-contain"
                        />
                    </div>
                    <p class="font-semibold truncate">ဂိမ်းပိုက်ဆံအိတ်</p>
                    <div
                        :class="[
                            'shrink-0 rounded-full bg-black flex items-center justify-center text-white font-bold',
                            helpBadgeClass,
                        ]"
                    >
                        ?
                    </div>
                </div>
                <p
                    :class="[
                        'font-semibold whitespace-nowrap text-right',
                        amountClass,
                    ]"
                >
                    {{ formatBalance(gameBalance) }} ကျပ်
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "WalletBalancesCard",
    props: {
        mainBalance: {
            type: [Number, String],
            default: 0,
        },
        gameBalance: {
            type: [Number, String],
            default: 0,
        },
        amountClass: {
            type: String,
            default: "",
        },
        helpBadgeClass: {
            type: String,
            default: "w-6 h-6 text-sm",
        },
    },
    methods: {
        formatBalance(value) {
            return value?.toLocaleString?.() ?? "";
        },
    },
};
</script>
