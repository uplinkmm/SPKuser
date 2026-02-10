<template lang="">
    <div class="frame-container px-4 min-h-[100vh] bg-[#FFC529]">
        <Navbar
            title=""
            :is-home-page="true"
            :hide-back-btn="true"
            :need-auth="false"
        ></Navbar>

        <div class="mb-8 relative">
            <!-- <div class="marquee bg-gray-900 text-white text-sm py-2 absolute top-0 left-4 ring-4">
                <div class="w-fit whitespace-nowrap">
                    <span class=" w-full inline mr-16 py-2">
                        ငွေသွင်း ငွေထုတ် ဝန်ဆောင်မှုကို ၂၄ နာရီ ပိတ်ရက်မရှိပြုလုပ်နိုင်ပါသည်...
                    </span> 
                    <span class=" w-full inline mr-16 py-2">
                        🚀 Welcome to our website! Enjoy fast and secure service — always.
                    </span> 
                </div>
                
            </div> -->
            <div
                v-if="marqueeAds"
                class="overflow-hidden mb-5 z-50 whitespace-nowrap bg-[#354ebd70] absolute top-0 left-4 right-4"
            >
                <div style="position: relative; min-height: 20px">
                    <div
                        id="marquee-text"
                        class="block text-white text-xs font-semibold py-1"
                        style="position: absolute; white-space: nowrap"
                    >
                        {{ marqueeAds?.name }}
                    </div>
                </div>
            </div>

            <div class="relative" id="ad_slick">
                <div class="mx-3" v-for="(ads, index) in adses" :key="index">
                    <img
                        :src="`${img_prefix}${ads.photo}`"
                        class="w-full aspect-video mb-3 rounded-2xl object-cover"
                    />
                </div>

                <div class="mx-3" v-if="!adses?.length">
                    <img
                        src="https://admin.shweshankan.com/storage/img/dyt40RFxWQTLfiBoxWeWV7BWqjASiHTCHtI7l9kJ.jpg"
                        class="w-full aspect-video mb-6 rounded-2xl object-cover"
                    />
                </div>

                <!-- <div class="absolute left-3 right-3 bottom-3">
                    <div class="background-black/90 rounded-xl py-2 px-3">
                        <p
                            class="text-gray-200 text-center text-sm font-semibold mb-0"
                        >
                            မင်္ဂလာပါ ရွှေပေါက်ကံမှ ကြိုဆိုပါတယ်။
                        </p>
                    </div>
                </div> -->
            </div>

            <div
                v-if="!getUser"
                class="bg-[#FFC529] mb-6 rounded-2xl shadow-lg flex justify-center flex-col"
            >
                <a href="/login_register">
                    <div
                        class="flex justify-start gap-x-4 w-10/12 mx-auto py-6"
                    >
                        <img
                            class="w-16"
                            src="../../../../public/img/Sign_in_squre_light.svg"
                        />
                        <div class="content-center">
                            <p class="text-white text-lg pb-1 pl-2">
                                Click Here to Login
                            </p>
                            <p class="text-white text-sm pb-0 pl-2">
                                Login ဝင်ရန် နှိပ်ပါ
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="bg-[#FFC529] rounded-t-3xl rounded-b-2xl pt-1">
                <ul
                    class="flex space-x-4 px-2 mb-3"
                    role="tablist"
                    data-twe-nav-ref
                >
                    <li role="presentation">
                        <a
                            href="#tabs-twoD-threeD"
                            class="my-1 block px-2 pb-2 font-semibold pt-3 text-md text-black data-[twe-nav-active]:after:!block underline-border relative"
                            data-twe-toggle="pill"
                            data-twe-target="#tabs-twoD-threeD"
                            data-twe-nav-active
                            role="tab"
                            aria-controls="tabs-twoD-threeD"
                            aria-selected="true"
                            >2D 3D</a
                        >
                    </li>
                    <li role="presentation">
                        <a
                            href="#lottery"
                            class="my-1 block px-2 pb-2 font-semibold pt-3 text-md text-black data-[twe-nav-active]:after:!block underline-border relative"
                            data-twe-toggle="pill"
                            data-twe-target="#lottery"
                            role="tab"
                            aria-controls="lottery"
                            aria-selected="false"
                            >ကံစမ်းမဲ</a
                        >
                    </li>
                    <li role="presentation">
                        <a
                            href="#"
                            class="my-1 block px-2 pb-2 font-semibold pt-3 text-md text-black"
                            role="tab"
                            aria-selected="false"
                            >ကံထူးမဲ</a
                        >
                    </li>
                    <li role="presentation">
                        <a
                            href="#"
                            class="my-1 block px-2 pb-2 font-semibold pt-3 text-md text-black"
                            role="tab"
                            aria-selected="false"
                            >Games</a
                        >
                    </li>
                </ul>
            </div>

            <div class="tab-content w-full">
                <div
                    class="hidden data-[twe-tab-active]:block"
                    id="tabs-twoD-threeD"
                    role="tabpanel"
                    aria-labelledby="tabs-twoD-threeD-tab"
                    data-twe-tab-active
                >
                    <div
                        class="grid grid-cols-2 gap-4 mb-4 items-stretch h-[320px]"
                    >
                        <HomeTwoDLive class="h-full" />
                        <div class="flex flex-col gap-4 h-full">
                            <a
                                href="/2D_betting"
                                class="background-black flex-1 rounded-2xl shadow-lg flex items-center justify-center"
                            >
                                <div class="text-center">
                                    <p
                                        class="text-[#D3A12A] text-3xl font-bold mb-2"
                                    >
                                        2D
                                    </p>
                                    <p
                                        class="text-[#D3A12A] text-2xl font-bold mb-0"
                                    >
                                        ထိုးမည်
                                    </p>
                                </div>
                            </a>
                            <a
                                href="/3D_betting"
                                class="background-black flex-1 rounded-2xl shadow-xl flex items-center justify-center"
                            >
                                <div class="text-center">
                                    <p
                                        class="text-[#D3A12A] text-3xl font-bold mb-2"
                                    >
                                        3D
                                    </p>
                                    <p
                                        class="text-[#D3A12A] text-2xl font-bold mb-0"
                                    >
                                        ထိုးမည်
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div
                        class="background-black mb-4 rounded-2xl shadow-lg flex justify-center flex-col"
                    >
                        <a href="/winner_lists/1" class="w-full">
                            <div class="py-3 text-center">
                                <p
                                    class="text-white text-base font-semibold mb-0"
                                >
                                    ထီပေါက်သူများ
                                </p>
                            </div>
                        </a>
                    </div>

                    <div
                        class="background-black mb-4 rounded-2xl shadow-lg flex justify-center flex-col"
                    >
                        <a href="/lottery_history" class="w-full">
                            <div class="py-3 text-center">
                                <p
                                    class="text-white text-base font-semibold mb-0"
                                >
                                    ထီပေါက်စဉ်များ
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div
                    class="hidden data-[twe-tab-active]:block"
                    id="lottery"
                    role="tabpanel"
                    aria-labelledby="lottery-tab"
                >
                    <div class="w-full">
                        <div class="mb-12">
                            <a
                                :href="`/lottery?id=${lottery.id}`"
                                v-for="(lottery, index) in lottery_lists"
                                :key="index"
                            >
                                <div class="mb-4">
                                    <div
                                        class="w-full h-36 overflow-hidden border"
                                    >
                                        <img
                                            :src="`${img_prefix}${lottery.photo}`"
                                            class="w-full object-cover mb-6 rounded"
                                        />
                                    </div>
                                    <p class="mt-2">{{ lottery.name }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="grid grid-cols-2 gap-x-4 mb-4">
                <HomeTwoDLive />
                <div>
                    <a
                        href="/2D_betting"
                        class="background-black aspect-[1/0.8] mb-4 rounded-2xl shadow-lg flex justify-center flex-col"
                    >
                        <div class="w-fit mx-auto flex">
                            <div>
                                <img
                                    class="w-4/12 mb-4 pt-4 lg:pt-0"
                                    src="../../../../public/img/image 2.png"
                                />
                                <p
                                    class="text-white text-xl self-end pb-6 pl-4"
                                >
                                    2D ထိုးမည်
                                </p>
                            </div>
                        </div>
                    </a>
                    <a
                        href="/3D_betting"
                        class="background-black aspect-[1/0.8] rounded-2xl shadow-xl flex justify-center flex-col"
                    >
                        <div class="w-fit mx-auto flex">
                            <div>
                                <img
                                    class="w-4/12 mb-4 pt-4 lg:pt-0"
                                    src="../../../../public/img/Map_fill.png"
                                />
                                <p
                                    class="text-white text-xl self-end pb-6 pl-4"
                                >
                                    3D ထိုးမည်
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div
                class="background-black mb-4 rounded-2xl shadow-lg flex justify-center flex-col"
            >
                <a href="/winner_lists/1">
                    <div
                        class="flex justify-start gap-x-4 w-10/12 mx-auto py-4"
                    >
                        <img
                            class="w-16 my-4"
                            src="../../../../public/img/Chart_white.png"
                        />
                        <div class="flex justify-center flex-col">
                            <p class="text-white text-xl pb-0 pl-2 mb-1">
                                ထီပေါက်သူများ
                            </p>
                            <p class="text-white text-sm pb-0 pl-2">
                                ထီပေါက်သူများ
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div
                class="background-black mb-4 rounded-2xl shadow-lg flex justify-center flex-col"
            >
                <a href="/lottery_history">
                    <div
                        class="flex justify-start gap-x-4 w-10/12 mx-auto py-4"
                    >
                        <img
                            class="w-16 my-4"
                            src="../../../../public/img/Chart_white.png"
                        />
                        <div class="flex justify-center flex-col">
                            <p
                                class="text-white text-xl pb-0 pl-2 font-semibold mb-1"
                            >
                                ထီပေါက်စဉ်များ
                            </p>
                            <p class="text-white text-sm pb-0 pl-2">
                                ထွက်ခဲ့သော နံပတ်များ
                            </p>
                        </div>
                    </div>
                </a>
            </div> -->
        </div>

        <div class="px-4 mb-6">
            <div class="flex justify-between px-4 mb-2">
                <p class="text-sm text-white font-bold mb-0"></p>
                <a href="/slots" class="text-xs text-white font-semibold mb-0">
                    See All
                </a>
            </div>

            <div class="">
                <ul
                    class="flex items-center justify-start overflow-auto w-full mb-1 hidden-scrollbar pb-4"
                    role="tablist"
                    data-twe-nav-ref
                >
                    <!-- <li class="tab-list-item-first active-tabs"  v-for="(type, index) in gameTypes" :key="index">
                        <span class="tab-list-item-text">All</span>
                    </li> -->

                    <li
                        v-for="(type, index) in gameTypes"
                        :key="index"
                        class="my-2 block pr-4 pb-2 font-semibold pt-1 text-sm relative whitespace-nowrap cursor-pointer underline-border"
                        :class="
                            type == selectedGameType
                                ? 'after:!block text-black'
                                : 'text-gray-600'
                        "
                    >
                        <a
                            @click="
                                selectedGameType = type;
                                getProviders();
                            "
                            class=""
                            >{{ type.name }}</a
                        >
                    </li>
                </ul>
                <!-- <ul
                    class="mb-0 flex gap-x-3 list-none flex-row flex-wrap border-b-0"
                    role="tablist"
                    data-twe-nav-ref
                >
                    <li v-for="(type, index) in gameTypes" :key="index">
                        <a
                            @click="
                                selectedGameType = type;
                                getProviders();
                            "
                            :class="
                                type?.name == selectedGameType?.name
                                    ? 'text-md'
                                    : 'text-xs'
                            "
                            class="my-2 block text-white border-x-0 border-b-2 border-t-0 border-transparent font-normal uppercase leading-tight hover:isolate hover:border-transparent focus:isolate focus:border-transparent data-[twe-nav-active]:border-none data-[twe-nav-active]:text-black data-[twe-nav-active]:font-semibold"
                            >{{ type.name }}</a
                        >
                    </li>
                </ul> -->

                <div class="mb-6">
                    <div
                        class="transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                        id="tabs-home"
                        role="tabpanel"
                        aria-labelledby="tabs-home-tab"
                        data-twe-tab-active
                    >
                        <div class="mb-12">
                            <div class="w-full">
                                <div
                                    class="w-full grid grid-cols-2 gap-x-4 lg:gap-x-6 gap-y-4"
                                >
                                    <div class="relative">
                                        <a
                                            href="/buffalo_rooms"
                                            class="cursor-pointer"
                                        >
                                            <img
                                                src="../../../../public/img/buffalo/750x500.png"
                                                class="w-full aspect-[3/2] rounded-lg"
                                                alt=""
                                            />
                                            <p
                                                class="text-white text-center pt-1 text-sm"
                                            >
                                                Buffalo game
                                            </p>
                                        </a>
                                    </div>
                                    <div
                                        v-for="(product, index) in providers
                                            ?.game_type?.products"
                                        :key="index"
                                        class="relative"
                                    >
                                        <a
                                            :href="`/slots/game_lists?provider=${JSON.stringify(
                                                {
                                                    id: product.id,
                                                    name: product.name,
                                                    code: product.code,
                                                },
                                            )}&game_type=${JSON.stringify({
                                                id: selectedGameType.id,
                                                name: selectedGameType.name,
                                            })}`"
                                            class="cursor-pointer"
                                        >
                                            <img
                                                class="w-full aspect-[3/2] rounded-lg"
                                                :src="product.pivot.image"
                                                alt=""
                                            />
                                            <p
                                                class="text-white text-center pt-1 text-sm"
                                            >
                                                {{ product.name }}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-16 px-4">
            <div>
                <p class="w-full text-[#eb5c00] text-2xl text-center mb-4">
                    CONTACT <span class="font-bold">US</span>
                </p>
            </div>
            <div>
                <ul class="text-white">
                    <li class="mb-4 group">
                        <a
                            href="https://www.facebook.com/share/1Qj3PFFJiD/"
                            class="flex gap-x-4"
                        >
                            <div
                                class="w-12 h-12 rounded-full bg-neutral-200 group-hover:bg-[#eb5c00] transition duration-700 ease-in-out flex items-center justify-center"
                            >
                                <svg
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="text-[#1d1848] text-xl lg:text-2xl group-hover:text-[#FFF] transition duration-700 ease-in-out"
                                    height="1em"
                                    width="1em"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold">
                                <p>Facebook :</p>
                                <p>/shwe.shan.kan</p>
                            </div>
                        </a>
                    </li>
                    <li class="mb-4 group">
                        <a
                            href="viber://chat/?number=09955511333"
                            class="flex gap-x-4"
                        >
                            <div
                                class="w-12 h-12 rounded-full bg-neutral-200 group-hover:bg-[#eb5c00] transition duration-700 ease-in-out flex items-center justify-center"
                            >
                                <svg
                                    stroke="currentColor"
                                    fill="currentColor"
                                    stroke-width="0"
                                    viewBox="0 0 512 512"
                                    class="text-[#1d1848] text-xl lg:text-2xl group-hover:text-[#FFF] transition duration-700 ease-in-out"
                                    height="1em"
                                    width="1em"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold">
                                <p>Viber :</p>
                                <p>09955511333</p>
                            </div>
                        </a>
                    </li>
                    <li class="mb-4 group">
                        <a href="tel:+959955511333" class="flex gap-x-4">
                            <div
                                class="w-12 h-12 rounded-full bg-neutral-200 group-hover:bg-[#eb5c00] transition duration-700 ease-in-out flex items-center justify-center"
                            >
                                <svg
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="text-[#1d1848] text-xl lg:text-2xl group-hover:text-[#FFF] transition duration-700 ease-in-out"
                                    height="1em"
                                    width="1em"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold">
                                <p>Call :</p>
                                <p>09955511333</p>
                            </div>
                        </a>
                    </li>
                    <li class="mb-4 group">
                        <a
                            href="tg://resolve?domain=shweshankan_gaming"
                            target="_blank"
                            class="flex gap-x-4"
                        >
                            <div
                                class="w-12 h-12 rounded-full bg-neutral-200 group-hover:bg-[#eb5c00] transition duration-700 ease-in-out flex items-center justify-center"
                            >
                                <svg
                                    stroke="currentColor"
                                    fill="currentColor"
                                    stroke-width="0"
                                    viewBox="0 0 24 24"
                                    class="text-[#1d1848] text-xl lg:text-2xl group-hover:text-[#FFF] transition duration-700 ease-in-out"
                                    height="1em"
                                    width="1em"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l.002.001-.314 4.692c.46 0 .663-.211.921-.46l2.211-2.15 4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.434z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold">
                                <p>Telegram :</p>
                                <p>t.me/shweshankan_gaming</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex/dist/vuex.cjs.js";
import Navbar from "../Nav/Navbar.vue";
import { Modal, Tab, Ripple, initTWE, Input } from "tw-elements";
import {
    getApiData,
    postApiData,
    postApiDataSlot,
} from "../../utilities/ajax-helpers";
import HomeTwoDLive from "./HomeTwoDLive.vue";
export default {
    name: "Home",
    components: {
        Navbar,
        HomeTwoDLive,
    },
    data() {
        return {
            adses: [],
            img_prefix: "",
            twoDList: "",
            intervalId: null,
            slots: [],
            gameTypes: [],
            selectedGameType: "",
            selectedProvider: "",
            providers: [],
            marqueeAds: null,
            lottery_lists: [],
        };
    },
    computed: {
        ...mapGetters(["getUser", "getToken"]),
    },
    methods: {
        async getAds() {
            let url = `/api/get_ads`;
            let response = await getApiData({
                url: url,
            });
            if (response.data) {
                this.adses = response.data;
            }
        },
        async get2DList() {
            const response = await getApiData({
                url: "https://admin.2dmyanmarpro.com/api/2d/live",
            });
            if (response.data) {
                this.twoDList = response.data;
            } else {
            }
        },
        async getGameTypes() {
            let url = `/api/gameType`;

            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.gameTypes = response.data;
            this.selectedGameType = this.gameTypes[0];
            this.getProviders();
        },
        async getMarqueeAds() {
            let url = `/api/get_marquee_ads`;

            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.marqueeAds = response.data;
        },
        async getProviders() {
            if (this.selectedGameType.id == 0) {
                this.getActiveLotteryLists();
                return;
            }
            let url = `/api/gameTypeProducts/${this.selectedGameType.id}`;
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.providers = response.data;
            this.selectedProvider = response.data.game_type.products[0];
        },
        async getActiveLotteryLists() {
            let url = `/api/lottery_list`;
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.lottery_lists = response.data;
        },
    },
    watch: {
        marqueeAds(newVal) {
            if (newVal) {
                this.$nextTick(() => {
                    function animateMarquee() {
                        const marqueeText = $("#marquee-text");
                        const container = marqueeText.parent();
                        const containerWidth = container.width();
                        const textWidth = marqueeText.width();

                        marqueeText.css({ left: containerWidth });

                        marqueeText.animate(
                            { left: -textWidth },
                            20000, // Adjust the duration as needed
                            "linear",
                            function () {
                                // Reset the animation
                                animateMarquee();
                            },
                        );
                    }

                    animateMarquee();
                });
            }
        },
        adses(newVal) {
            if (newVal.length > 0) {
                this.$nextTick(() => {
                    if ($("#ad_slick").length) {
                        $("#ad_slick").slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            dots: false,
                            arrows: false,
                            responsive: [
                                {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 4,
                                    },
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 3,
                                    },
                                },
                                {
                                    breakpoint: 640,
                                    settings: {
                                        slidesToShow: 3,
                                    },
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                    },
                                },
                            ],
                        });
                    }
                });
            }
        },
    },
    mounted() {
        // this.getGameLists();
        this.getGameTypes();
        this.getMarqueeAds();
        this.getActiveLotteryLists();

        if (window.location.href.includes("shwepaukkan")) {
            this.img_prefix = "https://admin.shwepaukkan.com";
        } else if (window.location.href.includes("test")) {
            this.img_prefix = "http://spkadmin.test";
        } else {
            this.img_prefix = "http://localhost:8001";
        }
        this.getAds();
        // this.intervalId = setInterval(this.get2DList, 3000);

        initTWE({ Modal, Tab, Ripple });

        // function animateMarquee() {
        //     const marqueeText = $("#marquee-text");
        //     const container = marqueeText.parent();
        //     const containerWidth = container.width();
        //     const textWidth = marqueeText.width();

        //     marqueeText.css({ left: containerWidth });

        //     marqueeText.animate(
        //         { left: -textWidth },
        //         20000, // Adjust the duration as needed
        //         "linear",
        //         function () {
        //             // Reset the animation
        //             animateMarquee();
        //         }
        //     );
        // }

        // // animateMarquee();
    },
};
</script>
<style lang=""></style>
