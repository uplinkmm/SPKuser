<template lang="">
    <div>
        <div class="hidden fixed top-0 z-50 w-full border-b bg-white shadow-md">
            <div class="flex justify-end px-6 w-10/12 mx-auto">
                <ul class="flex flex-row gap-x-6 py-4">
                    <li class="self-end pb-0.5 text-base text-black">
                        <a href="#"> Home </a>
                    </li>
                    <li class="self-end pb-0.5 text-base text-gray-600">
                        <a href="#"> Promotion </a>
                    </li>
                    <li class="self-end pb-0.5 text-base text-gray-600">
                        <a href="#"> 2D </a>
                    </li>
                    <li class="self-end pb-0.5 text-base text-gray-600">
                        <a href="#"> Notification </a>
                    </li>
                    <li class="self-end pb-0.5 text-base text-gray-600">
                        <a href="#"> Profile </a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="block w-full sm:w-3/12 sm:min-w-[480px] mx-auto rounded-none shadow-lg fixed left-0 right-0 bottom-0 z-50 bg-[#fedc23] border-t border-[#C67D06]"
        >
            <div class="grid grid-cols-4 px-[2%] pt-1">
                <div class="text-center">
                    <a
                        href="/home"
                        class="py-3 text-xs w-full relative flex flex-col"
                        :class="
                            checkActiveUrl(['home'])
                                ? 'text-[#C67D06]'
                                : 'text-black'
                        "
                    >
                        <i class="fal fa-home-lg-alt block pb-1"></i>
                        {{ $t("Home") }}
                    </a>
                </div>
                <!-- <div class=" text-center">
                  <a
                      href="/category"
                      class="py-3 text-xs w-full relative flex flex-col text-black"
                  >
                      <i class="fas fa-th-large block pb-1"></i>
                      Category
                  </a>
              </div> -->
                <div class="text-center">
                    <a
                        href="/wallet"
                        class="py-3 text-xs w-full relative flex flex-col"
                        :class="
                            checkActiveUrl(['wallet', 'topup', 'cash_withdraw'])
                                ? 'text-[#C67D06]'
                                : 'text-black'
                        "
                    >
                        <i class="fal fa-wallet block pb-1"></i>
                        {{ $t("Wallet") }}
                    </a>
                </div>
                <div class="text-center">
                    <a
                        href="/profile"
                        class="py-3 text-xs w-full relative flex flex-col"
                        :class="
                            checkActiveUrl(['profile'])
                                ? 'text-[#C67D06]'
                                : 'text-black'
                        "
                    >
                        <i class="fal fa-user-alt block pb-1"></i>
                        {{ $t("Profile") }}
                    </a>
                </div>
                <div class="text-center">
                    <a
                        href="/notifications"
                        class="py-3 text-xs w-full relative flex flex-col"
                        :class="
                            checkActiveUrl(['notifications'])
                                ? 'text-[#C67D06]'
                                : 'text-black'
                        "
                    >
                        <i class="fal fa-bell block pb-1"></i>
                        {{ $t("Notification") }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    methods: {
        checkActiveUrl(urls) {
            let currentUrl = window.location.href;
            let isActive = false;
            urls.forEach((url) => {
                let currentUrlSplit = currentUrl.split("/");
                console.log("url", url, currentUrlSplit.includes(url));
                if (currentUrlSplit.includes(url)) {
                    isActive = true;
                }
            });
            return isActive;
        },
    },
    mounted() {
        this.checkActiveUrl(["home"]);
        this.checkActiveUrl(["wallet", "topup", "cash_withdraw"]);
    },
};
</script>
<style lang=""></style>
