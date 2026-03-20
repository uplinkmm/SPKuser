<template>
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4 mb-20">
            <Navbar
                title=""
                :is-home-page="true"
                :hide-back-btn="true"
                :need-auth="false"
            ></Navbar>
        </div>

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
            <!-- <div
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
            </div> -->

            <div class="relative">
                <div id="ad_slick">
                    <div class="" v-for="ads in adses" :key="ads.id">
                        <img
                            :src="`${img_prefix}${ads.photo}`"
                            class="w-full aspect-video object-cover"
                        />
                    </div>

                    <!-- <div class="" v-if="!adses?.length">
                        <img
                            src="https://admin.shweshankan.com/storage/img/dyt40RFxWQTLfiBoxWeWV7BWqjASiHTCHtI7l9kJ.jpg"
                            class="w-full aspect-video mb-6 object-cover"
                        />
                    </div> -->
                </div>

                <div
                    v-if="marqueeAds"
                    class="overflow-hidden z-50 whitespace-nowrap py-2 bg-[#00000090] absolute left-3 right-3 -bottom-5 rounded-xl"
                >
                    <div style="position: relative; min-height: 20px">
                        <div
                            id="marquee-text"
                            class="block text-gray-200 text-center text-sm font-semibold py-1"
                            style="position: absolute; white-space: nowrap"
                        >
                            {{ marqueeAds?.name }}
                        </div>
                    </div>
                </div>
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

            <div class="bg-[#FFC529] rounded-t-3xl pt-1 px-6 pb-8">
                <div class="">
                    <ul
                        class="flex list-none flex-row flex-wrap border-b-0 ps-0 px-2 pb-2 mb-2"
                        role="tablist"
                        data-twe-nav-ref
                    >
                        <li role="presentation">
                            <a
                                href="#tabs-twoD-threeD"
                                class="my-2 block px-2 pb-3.5 pt-4 text-sm text-black hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-blue-600 font-semibold"
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
                                class="my-2 block px-2 pb-3.5 pt-4 text-sm text-black hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-blue-600 font-semibold"
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
                                href="#slot_games"
                                class="my-2 block px-2 pb-3.5 pt-4 text-sm text-black hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-blue-600 font-semibold"
                                data-twe-toggle="pill"
                                data-twe-target="#slot_games"
                                role="tab"
                                aria-controls="slot_games"
                                aria-selected="false"
                                @click="selectGameTypeById(1)"
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
                            <div
                                v-if="lottery_lists && lottery_lists.length"
                                class="mb-12"
                            >
                                <a
                                    :href="`/lottery?id=${lottery.id}`"
                                    v-for="(lottery, index) in lottery_lists"
                                    :key="index"
                                    class="block mb-6"
                                >
                                    <div
                                        class="w-full rounded-3xl overflow-hidden bg-black shadow-lg"
                                    >
                                        <div
                                            class="w-full h-44 overflow-hidden"
                                        >
                                            <img
                                                :src="`${img_prefix}${lottery.photo}`"
                                                class="w-full h-full object-cover"
                                            />
                                        </div>

                                        <div
                                            class="bg-black py-4 px-4 text-center"
                                        >
                                            <p
                                                class="text-white text-lg font-thin mb-0"
                                            >
                                                {{ lottery.name }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div
                                v-else
                                class="mb-12 flex items-center justify-center py-12 text-center"
                            >
                                <p class="text-sm text-black">Coming Soon...</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="hidden data-[twe-tab-active]:block"
                        id="slot_games"
                        role="tabpanel"
                        aria-labelledby="slot_games-tab"
                    >
                        <div class="mb-12">
                            <div class="w-full">
                                <div
                                    class="w-full grid grid-cols-3 gap-x-4 gap-y-6"
                                >
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
                                                    image: providerLocalImage(
                                                        product,
                                                    ),
                                                },
                                            )}&game_type=${JSON.stringify({
                                                id: selectedGameType.id,
                                                name: selectedGameType.name,
                                            })}`"
                                            class="cursor-pointer block"
                                        >
                                            <div
                                                :class="[
                                                    'w-full aspect-square rounded-2xl p-3 flex items-center justify-center overflow-hidden shadow-sm',
                                                    providerLogoNeedsDarkBackground(
                                                        product,
                                                    )
                                                        ? 'bg-[#101828]'
                                                        : 'bg-white',
                                                ]"
                                            >
                                                <img
                                                    class="w-full h-full object-contain"
                                                    :src="
                                                        providerLocalImage(
                                                            product,
                                                        )
                                                    "
                                                    :alt="product.name"
                                                />
                                            </div>
                                            <p
                                                class="text-white text-left pt-2 text-lg leading-tight truncate"
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

                <div class="px-4 mb-6">
                    <div class="flex justify-between px-4 mb-2">
                        <p class="text-sm text-white font-bold mb-0"></p>
                        <a
                            href="/slots"
                            class="text-md text-black hover:underline font-semibold mb-0"
                        >
                            See All Games
                        </a>
                    </div>

                    <div class="">
                        <div
                            class="flex items-center justify-between px-4 mb-3"
                        >
                            <p class="text-md text-black font-semibold mb-0">
                                အဆော့များသော ဂိမ်းများ
                            </p>
                        </div>

                        <div class="grid grid-cols-3 gap-4 px-4">
                            <div class="relative">
                                <a
                                    href="/buffalo_rooms"
                                    class="cursor-pointer block"
                                >
                                    <img
                                        src="../../../../public/img/buffalo/750x500.png"
                                        class="w-full aspect-square rounded-2xl object-cover"
                                        alt=""
                                    />
                                    <p
                                        class="text-white text-left pt-2 text-lg leading-tight truncate"
                                    >
                                        Buffalo game
                                    </p>
                                </a>
                            </div>
                            <div
                                v-for="(game, index) in hotGames"
                                :key="index"
                                class="relative"
                            >
                                <a
                                    @click.prevent="getGameUrl(game)"
                                    class="cursor-pointer block"
                                    :class="{
                                        'opacity-70': loading === game.code,
                                    }"
                                >
                                    <div
                                        v-if="loading === game.code"
                                        class="absolute inset-0 flex top-10 justify-center"
                                    >
                                        <div
                                            class="animate-spin rounded-full h-8 w-8 border-b-2 border-white pb-8"
                                        ></div>
                                    </div>
                                    <img
                                        :src="game.image_url"
                                        class="w-full aspect-square rounded-2xl object-cover"
                                        alt=""
                                    />
                                    <p
                                        class="text-white text-left pt-2 text-lg leading-tight truncate"
                                    >
                                        {{ game.name }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-16 px-4">
                        <div>
                            <p
                                class="w-full text-[#eb5c00] text-2xl text-center mb-4"
                            >
                                CONTACT <span class="font-bold">US</span>
                            </p>
                        </div>
                        <div>
                            <ul class="text-white">
                                <li class="mb-4 group">
                                    <a
                                        :href="contactUs?.facebook_link || '#'"
                                        target="_blank"
                                        rel="noopener noreferrer"
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
                                            <p>
                                                {{
                                                    compactLink(
                                                        contactUs?.facebook_link,
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-4 group">
                                    <a :href="viberLink()" class="flex gap-x-4">
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
                                            <p>
                                                {{
                                                    contactUs?.viber_number ||
                                                    "-"
                                                }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-4 group">
                                    <a :href="phoneLink()" class="flex gap-x-4">
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
                                            <p>
                                                {{
                                                    contactUs?.phone_number ||
                                                    "-"
                                                }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-4 group">
                                    <a
                                        :href="contactUs?.telegram_link || '#'"
                                        target="_blank"
                                        rel="noopener noreferrer"
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
                                            <p>
                                                {{
                                                    compactLink(
                                                        contactUs?.telegram_link,
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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

const PROVIDER_IMAGE_MAP = {
    cq9: "/providers/slots/cq9.png",
    playstar: "/providers/slots/playstar.png",
    mrslotty: "/providers/slots/mrslotty.png",
    bgaming: "/providers/slots/bgaming.png",
    voltentertainment: "/providers/slots/volt-entertainment.png",
    fazi: "/providers/slots/fazi.png",
    netgame: "/providers/slots/netgame.png",
    netgameentertainment: "/providers/slots/netgame.png",
    kiron: "/providers/slots/kiron.png",
    redrake: "/providers/slots/redrake.webp",
    redrakegaming: "/providers/slots/redrake.webp",
    booongo: "/providers/slots/booongo.png",
    funtagaming: "/providers/slots/funtagaming.png",
    felix: "/providers/slots/felix.png",
    felixgaming: "/providers/slots/felix.png",
    zeusplay: "/providers/slots/zeusplay.png",
    wowgaming: "/providers/slots/wow-gaming.png",
    pragmaticplay: "/providers/slots/pragmatic-play.png",
    jilitcg: "/providers/slots/jili-tcg.png",
    jili: "/providers/slots/jili-tcg.png",
    live22: "/providers/slots/live22.png",
    jdb: "/providers/slots/jdb.png",
    hacksaw: "/providers/slots/hacksaw.png",
    hacksawgaming: "/providers/slots/hacksaw.png",
    bigpot: "/providers/slots/bigpot.png",
    bigpotgaming: "/providers/slots/bigpot.png",
    rich88: "/providers/slots/rich88.png",
    fachai: "/providers/slots/fachai.png",
    pgsoft: "/providers/slots/pg-soft.png",
    pocketgamesoft: "/providers/slots/pg-soft.png",
    pascalgaming: "/providers/slots/pascal-gaming.png",
    epicwin: "/providers/slots/epicwin.png",
    novomatic: "/providers/slots/novomatic.png",
    octoplay: "/providers/slots/octoplay.png",
    boominggames: "/providers/slots/booming-games.png",
    amigogaming: "/providers/slots/amigo-gaming.png",
    habanero: "/providers/slots/habanero.png",
    playace: "/providers/slots/playace.svg",
    spadegaming: "/providers/slots/spade-gaming.png",
    advantplay: "/providers/slots/advantplay.png",
    joker: "/providers/slots/joker.png",
};

function normalizeProviderImageKey(value) {
    return String(value || "")
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "");
}

export default {
    name: "Home",
    components: {
        Navbar,
        HomeTwoDLive,
    },
    data() {
        return {
            loading: null,
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
            hotGames: [],
            contactUs: null,
        };
    },
    computed: {
        ...mapGetters(["getUser", "getToken"]),
    },
    methods: {
        selectGameTypeById(id) {
            const found = this.gameTypes?.find((t) => t?.id === id);
            if (found) {
                this.selectedGameType = found;
                this.getProviders();
            }
        },
        async getHotGames(searchInput = "") {
            let url = `/api/hotGameList?search_input=${encodeURIComponent(
                searchInput,
            )}`;
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.hotGames = response.data ?? [];
        },
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
        async getContactUs() {
            let response = await getApiData({
                url: `/api/contact_us`,
                token: this.getToken,
            });
            const contactList = Array.isArray(response.data)
                ? response.data
                : [];
            this.contactUs =
                contactList.find((item) => Number(item.is_active) === 1) ||
                contactList[0] ||
                null;
        },
        compactLink(url) {
            if (!url) {
                return "-";
            }
            return String(url)
                .replace(/^https?:\/\//, "")
                .replace(/\/$/, "");
        },
        normalizePhoneNumber(phoneNumber) {
            const raw = String(phoneNumber || "").trim();
            if (!raw) {
                return "";
            }
            if (raw.startsWith("+")) {
                return raw;
            }
            const digits = raw.replace(/\D/g, "");
            if (!digits) {
                return "";
            }
            if (digits.startsWith("959") || digits.startsWith("95")) {
                return `+${digits}`;
            }
            if (digits.startsWith("09")) {
                return `+95${digits.slice(1)}`;
            }
            if (digits.startsWith("9")) {
                return `+95${digits}`;
            }
            return `+${digits}`;
        },
        viberLink() {
            const phone = this.normalizePhoneNumber(
                this.contactUs?.viber_number || this.contactUs?.phone_number,
            );
            return phone
                ? `viber://chat?number=${encodeURIComponent(phone)}`
                : "#";
        },
        phoneLink() {
            const phone = String(this.contactUs?.phone_number || "").trim();
            return phone ? `tel:${phone}` : "#";
        },
        providerLocalImage(product) {
            const candidates = [product?.name, product?.code];
            for (const candidate of candidates) {
                const key = normalizeProviderImageKey(candidate);
                if (PROVIDER_IMAGE_MAP[key]) {
                    return PROVIDER_IMAGE_MAP[key];
                }
            }
            return "/icons/provider_cover.png";
        },
        providerLogoNeedsDarkBackground(product) {
            return this.providerLocalImage(product) === "/providers/slots/kiron.png";
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
            this.selectedProvider =
                response.data?.game_type?.products?.[0] ?? "";
        },
        async getActiveLotteryLists() {
            let url = `/api/lottery_list`;
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.lottery_lists = response.data;
        },

        async getGameUrl(game) {
            this.loading = game.code;
            try {
                let url = `/api/operators/launch_game`;
                let formData = new FormData();
                formData.append("product_code", game.product_code);
                formData.append("game_type", game.game_type);
                formData.append("game_code", game.code);

                let response = await postApiDataSlot({
                    url: url,
                    form_data: formData,
                    token: this.getToken,
                });

                if (response.status === 200) {
                    this.$notify({
                        text: "Loading....",
                        type: "info",
                    });
                    window.open(response.data.url, "_blank");
                } else {
                    this.$notify({
                        text: "Something went wrong. Please try again!",
                        type: "error",
                    });
                }
            } catch (error) {
                this.$notify({
                    text: "Failed to launch game. Please try again.",
                    type: "error",
                });
            } finally {
                this.loading = null;
            }
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
                        if ($("#ad_slick").hasClass("slick-initialized")) {
                            $("#ad_slick").slick("unslick");
                        }
                        $("#ad_slick").slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            dots: false,
                            arrows: false,
                            pauseOnHover: false,
                        });
                    }
                });
            }
        },
    },
    mounted() {
        // this.getGameLists();
        this.getGameTypes();
        this.getHotGames();
        this.getMarqueeAds();
        this.getContactUs();
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
