<template>
    <div class="w-full h-full bg-black bg-img">
        <div class="frame-container min-h-[100vh] bg-black">
            <div class="mx-4">
                <Navbar :title="$t(title)" :back-btn="backBtn"></Navbar>
            </div>

            <div>
                <div v-show="step == 'mainProfile'">
                    <div class="pt-2 pb-6 bg-black">
                        <div
                            class="grid grid-cols-3 gap-3 text-white font-semibold px-12"
                        >
                            <div class="col-span-1">
                                <img
                                    src="../../../../public/img/profile.png"
                                    alt=""
                                    class="w-26 h-26 rounded-full"
                                />
                                <button
                                    type="button"
                                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                                >
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </div>
                            <div
                                class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8"
                            >
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>နာမည် :</p>
                                    <p>
                                        {{ user_profile_data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>ဖုန်းနံပါတ် :</p>
                                    <p>
                                        {{ user_profile_data?.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-6">
                        <div class="bg-[#FFC529] rounded-3xl px-5 py-5">
                            <p
                                class="text-center text-black text-lg font-semibold mb-4"
                            >
                                General Setting
                            </p>

                            <div class="flex flex-col">
                                <button
                                    type="button"
                                    @click="
                                        step = 'changePassStepOne';
                                        title = 'Change Password';
                                    "
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                        >
                                            <i
                                                class="fal fa-key text-[#CFA32B] text-lg"
                                            ></i>
                                        </div>
                                        <p class="text-black font-semibold">
                                            {{ $t("Change Password") }}
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </button>

                                <button
                                    @click="
                                        step = 'changeLang';
                                        title = 'Change Language';
                                    "
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                        >
                                            <i
                                                class="fal fa-language text-[#CFA32B] text-lg"
                                            ></i>
                                        </div>
                                        <p class="text-black font-semibold">
                                            {{ $t("Myanmar/English") }}
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </button>

                                <button
                                    @click="
                                        step = 'history';
                                        title = 'History';
                                    "
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                        >
                                            <i
                                                class="fal fa-book text-[#CFA32B] text-lg"
                                            ></i>
                                        </div>
                                        <p class="text-black font-semibold">
                                            {{ $t("History") }}
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </button>

                                <a
                                    href="#"
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                        >
                                            <i
                                                class="fal fa-comment-alt-lines text-[#CFA32B] text-lg"
                                            ></i>
                                        </div>
                                        <button
                                            type="button"
                                            @click="
                                                step = 'feedback';
                                                title = 'Feedback';
                                            "
                                            class="text-black font-semibold"
                                        >
                                            {{ $t("Feedback") }}
                                        </button>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>

                                <a
                                    href="#"
                                    @click="
                                        step = 'termsAndConditions';
                                        title = 'Term & Condition';
                                    "
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                        >
                                            <i
                                                class="fal fa-scroll-old text-[#CFA32B] text-lg"
                                            ></i>
                                        </div>
                                        <p class="text-black font-semibold">
                                            {{ $t("Term & Condition") }}
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>

                                <button
                                    type="button"
                                    @click="
                                        step = 'customerService';
                                        title = 'Customer Service';
                                    "
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                        >
                                            <i
                                                class="fal fa-phone text-[#CFA32B] text-lg"
                                            ></i>
                                        </div>
                                        <p class="text-black font-semibold">
                                            Customer Service သို့ ဆက်သွယ်ရန်
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </button>
                            </div>

                            <div class="mt-6 mb-16">
                                <button
                                    type="button"
                                    @click="logOut"
                                    class="w-full bg-[#D64545] text-white font-semibold py-4 rounded-2xl"
                                >
                                    ထွက်မည်
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Chagne Password -->
                <div
                    v-show="step == 'changePassStepOne'"
                    class="px-4 sm:px-8 py-12 mb-8"
                >
                    <div class="relative h-full flex flex-col justify-center">
                        <div class="mb-12 text-center">
                            <p class="text-2xl mb-4 font-semibold">
                                ပက်စ်ဝက်ပြောင်းရန်
                            </p>
                            <p class="text-sm mb-2 font-semibold">
                                အသစ်ထည့်လိုသော Password ထည့်သွင်းရန်
                            </p>
                        </div>
                        <div class="pb-16">
                            <label
                                class="mb-6 rounded-xl shadow-md bg-white block"
                            >
                                <p class="text-xs px-4 pt-4 text-gray-700">
                                    Old Password
                                </p>
                                <input
                                    type="password"
                                    v-model="current_password"
                                    placeholder="Old Password"
                                    class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                                />
                            </label>
                            <label
                                class="mb-6 rounded-xl shadow-md bg-white block"
                            >
                                <p class="text-xs px-4 pt-4 text-gray-700">
                                    New Password
                                </p>
                                <input
                                    type="password"
                                    v-model="new_password"
                                    placeholder="New Password"
                                    class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                                />
                            </label>
                            <label
                                class="mb-6 rounded-xl shadow-md bg-white block"
                            >
                                <p class="text-xs px-4 pt-4 text-gray-700">
                                    Confirm Password
                                </p>
                                <input
                                    type="password"
                                    v-model="new_password_confirmation"
                                    placeholder="Confirm Password"
                                    class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                                />
                            </label>
                        </div>
                        <div
                            class="mb-0 absolute bottom-4 flex justify-end w-full"
                        >
                            <button
                                @click="handelChangePasswordStepOne"
                                :disabled="passwordLoading"
                                class="bg-black disabled:bg-gray-600 text-white pl-8 pr-7 py-3 w-fit rounded-full"
                            >
                                {{ passwordLoading ? "Loading.." : "Submit" }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <div class="mb-4">
                    <label
                        for="old_password"
                        class="text-sm mb-2 relative block"
                        >Old Password</label
                    >
                    <input
                        type="password"
                        id="old_password"
                        placeholder="Old Password"
                        v-model="current_password"
                        class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="new_password"
                        class="text-sm mb-2 relative block"
                        >New Password
                    </label>
                    <input
                        type="password"
                        id="new_password"
                        placeholder="New Password"
                        v-model="new_password"
                        class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                    />
                </div>
                <div class="mb-8">
                    <label
                        for="confirm_password"
                        class="text-sm mb-2 relative block"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        id="confirm_password"
                        placeholder="Confirm Password"
                        v-model="new_password_confirmation"
                        class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                    />
                </div> -->

                <!-- <div class="mb-0">
                    <button
                        :disabled="loading"
                        @click="changePassword()"
                        class="bg-[#FDC652] text-white px-4 py-2 w-full"
                    >
                        {{ loading ? "Changing..." : "Done" }}
                    </button>
                </div> -->

                <div v-show="step == 'changeLang'">
                    <div class="pt-2 pb-6 bg-black">
                        <div
                            class="grid grid-cols-3 gap-3 text-white font-semibold px-12"
                        >
                            <div class="col-span-1 relative">
                                <img
                                    src="../../../../public/img/profile.png"
                                    alt=""
                                    class="w-26 h-26 rounded-full"
                                />
                                <button
                                    type="button"
                                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                                >
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </div>

                            <div
                                class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8"
                            >
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>နာမည် :</p>
                                    <p>
                                        {{ user_profile_data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>ဖုန်းနံပါတ် :</p>
                                    <p>
                                        {{ user_profile_data?.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-6">
                        <div class="bg-[#FFC529] rounded-3xl px-5 py-5">
                            <p
                                class="text-center text-black text-lg font-semibold mb-4"
                            >
                                ဘာသာစကားပြောင်းရန်
                            </p>

                            <div class="flex flex-col pl-3">
                                <button
                                    v-for="language in languages"
                                    :key="language.code"
                                    type="button"
                                    @click="selectedLocale = language.code"
                                    class="flex items-center justify-between py-3"
                                >
                                    <p class="text-black">
                                        {{ language.name }}
                                    </p>
                                    <div
                                        class="w-5 h-5 border border-black rounded-sm"
                                        :class="
                                            selectedLocale === language.code
                                                ? 'bg-[#5271FF] border-[#5271FF]'
                                                : ''
                                        "
                                    ></div>
                                </button>
                            </div>

                            <div class="mt-6 mb-16">
                                <button
                                    type="button"
                                    @click="confirmChangeLocale"
                                    class="w-full bg-[#5271FF] text-white font-semibold py-4 rounded-2xl"
                                >
                                    အတည်ပြုမည်
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="step == 'history'">
                    <div class="pt-2 pb-6 bg-black">
                        <div
                            class="grid grid-cols-3 gap-3 text-white font-semibold px-12"
                        >
                            <div class="col-span-1 relative">
                                <img
                                    src="../../../../public/img/profile.png"
                                    alt=""
                                    class="w-26 h-26 rounded-full"
                                />
                                <button
                                    type="button"
                                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                                >
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </div>

                            <div
                                class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8"
                            >
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>နာမည် :</p>
                                    <p>
                                        {{ user_profile_data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>ဖုန်းနံပါတ် :</p>
                                    <p>
                                        {{ user_profile_data?.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-6">
                        <div class="bg-[#FFC529] rounded-3xl px-5 py-5">
                            <p
                                class="text-center text-black text-lg font-semibold mb-4"
                            >
                                မှတ်တမ်းများ
                            </p>

                            <div class="flex flex-col">
                                <a
                                    href="/deposit_withdrawal_histories"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">
                                            ငွေသွင်းငွေထုတ် မှတ်တမ်းများ
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                                <a
                                    href="/history?game_id=1"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">2D မှတ်တမ်း</p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                                <a
                                    href="/history?game_id=2"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">3D မှတ်တမ်း</p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                                <a
                                    href="/winner_lists/1"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">ထီပေါက်သူများ</p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                                <a
                                    href="/lottery_history"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">ထီပေါက်စဉ်</p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                                <a
                                    href="/deposit_withdrawal_histories"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">
                                            ကံစမ်းမဲ မှတ်တမ်း
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                                <a
                                    href="/deposit_withdrawal_histories"
                                    class="flex items-center justify-between py-3"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <i
                                            class="fal fa-file-alt text-black text-xl w-6"
                                        ></i>
                                        <p class="text-black">
                                            ကံစမ်းမဲ ပေါက်မှတ်တမ်း
                                        </p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-black"
                                    ></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="step == 'feedback'">
                    <div class="pt-2 pb-6 bg-black">
                        <div
                            class="grid grid-cols-3 gap-3 text-white font-semibold px-12"
                        >
                            <div class="col-span-1 relative">
                                <img
                                    src="../../../../public/img/profile.png"
                                    alt=""
                                    class="w-26 h-26 rounded-full"
                                />
                                <button
                                    type="button"
                                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                                >
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </div>

                            <div
                                class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8"
                            >
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>နာမည် :</p>
                                    <p>
                                        {{ user_profile_data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>ဖုန်းနံပါတ် :</p>
                                    <p>
                                        {{ user_profile_data?.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-6">
                        <div class="bg-[#FFC529] rounded-3xl px-5 py-5">
                            <p
                                class="text-center text-black text-lg font-semibold mb-4"
                            >
                                အကြံပြုစာ
                            </p>

                            <div
                                class="flex items-center justify-between text-black mb-3"
                            >
                                <p class="font-semibold">
                                    {{ dateFormat(new Date()) }}
                                </p>
                                <p class="font-semibold">
                                    {{ timeFormat(new Date()) }}
                                </p>
                            </div>

                            <textarea
                                v-model="feedback"
                                rows="10"
                                class="w-full bg-[#D9D9D9] rounded-xl p-4 text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                            ></textarea>

                            <div class="mt-6 mb-16">
                                <button
                                    :disabled="loading"
                                    @click="sendFeedback"
                                    class="w-full bg-[#5271FF] disabled:bg-gray-600 text-white font-semibold py-4 rounded-2xl"
                                >
                                    အတည်ပြုမည်
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="step == 'customerService'">
                    <div class="pt-2 pb-6 bg-black">
                        <div
                            class="grid grid-cols-3 gap-3 text-white font-semibold px-12"
                        >
                            <div class="col-span-1 relative">
                                <img
                                    src="../../../../public/img/profile.png"
                                    alt=""
                                    class="w-26 h-26 rounded-full"
                                />
                                <button
                                    type="button"
                                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                                >
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </div>

                            <div
                                class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8"
                            >
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>နာမည် :</p>
                                    <p>
                                        {{ user_profile_data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>ဖုန်းနံပါတ် :</p>
                                    <p>
                                        {{ user_profile_data?.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-6">
                        <div class="bg-[#FFC529] rounded-3xl px-5 py-5">
                            <p
                                class="text-center text-black text-lg font-semibold mb-4"
                            >
                                Customer Service သို့ ဆက်သွယ်ရန်
                            </p>

                            <div class="flex flex-col">
                                <button
                                    v-for="item in customerServiceItems"
                                    :key="item.key"
                                    type="button"
                                    @click="openCustomerServiceLink(item.url)"
                                    class="flex items-center justify-between py-4"
                                >
                                    <div class="flex items-center gap-x-4">
                                        <img
                                            :src="item.icon"
                                            :alt="item.label"
                                            class="w-10 h-10 rounded-full"
                                        />
                                        <p class="text-black font-semibold">
                                            {{ item.label }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-x-3">
                                        <p class="text-[#1d4ed8] font-medium">
                                            {{ item.value }}
                                        </p>
                                        <i
                                            class="fas fa-chevron-right text-black"
                                        ></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="step == 'termsAndConditions'">
                    <div class="pt-2 pb-6 bg-black">
                        <div
                            class="grid grid-cols-3 gap-3 text-white font-semibold px-12"
                        >
                            <div class="col-span-1 relative">
                                <img
                                    src="../../../../public/img/profile.png"
                                    alt=""
                                    class="w-26 h-26 rounded-full"
                                />
                                <button
                                    type="button"
                                    class="absolute right-0 bottom-0 w-7 h-7 rounded-full bg-[#5271FF] text-white flex items-center justify-center"
                                >
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </div>

                            <div
                                class="col-span-2 space-y-5 font-inter mt-6 pl-4 pr-8"
                            >
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>နာမည် :</p>
                                    <p>
                                        {{ user_profile_data?.name }}
                                    </p>
                                </div>
                                <div
                                    class="flex justify-between items-center gap-x-4"
                                >
                                    <p>ဖုန်းနံပါတ် :</p>
                                    <p>
                                        {{ user_profile_data?.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-6">
                        <div class="bg-[#FFC529] rounded-3xl px-5 py-5">
                            <p
                                class="text-center text-black text-lg font-semibold mb-4"
                            >
                                စည်းကမ်းသတ်မှတ်ချက်များ
                            </p>

                            <div
                                class="bg-[#D9D9D9] rounded-xl p-4 border border-black/30 text-black h-[60vh] overflow-y-auto"
                            >
                                <div v-html="terms_and_conditions.name"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                data-twe-modal-init
                class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                id="contact_modal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div
                    data-twe-modal-dialog-ref
                    class="pointer-events-none relative w-[400px] mx-auto mt-[15%] translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[400px]"
                >
                    <div
                        class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                    >
                        <div
                            class="flex flex-shrink-0 items-center justify-between rounded-t-md border-neutral-100 py-8 px-6"
                        >
                            <h4
                                class="text-xl font-medium leading-normal text-surface text-center w-full"
                                id="exampleModalLabel"
                            >
                                {{ $t("Contacts") }}
                            </h4>
                            <button
                                type="button"
                                id="close_contact"
                                class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
                                data-twe-modal-dismiss
                                aria-label="Close"
                            >
                                <span class="[&>svg]:h-6 [&>svg]:w-6">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div
                            class="relative flex-auto pb-6 px-16"
                            data-twe-modal-body-ref
                        >
                            <div class="mb-8">
                                <div
                                    v-for="(contact, index) in contacts"
                                    :key="index"
                                    class="flex items-center p-4 bg-gray-50 rounded-lg shadow-sm"
                                >
                                    <div
                                        class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full"
                                    >
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p
                                            class="text-lg font-medium text-gray-800"
                                        >
                                            {{ contact.name }}
                                        </p>
                                        <a
                                            :href="
                                                'tel:' + contact.phone_number
                                            "
                                            class="text-blue-500 hover:underline"
                                        >
                                            {{ contact.phone_number }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Ripple, Dropdown, initTWE } from "tw-elements";
import { mapGetters, mapMutations } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import moment from "moment";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            step: "mainProfile", //changePassStepOne, changePassStepTwo , changeLang
            title: "Profile",
            user_profile_data: {},
            selectedLocale: null,
            current_password: "",
            new_password: "",
            new_password_confirmation: "",
            terms_and_conditions: "",
            feedback: "",
            contacts: [],
            loading: false,
            languages: [
                { code: "mm", name: "Myanmar" },
                { code: "en", name: "English" },
                { code: "cn", name: "Chinese" },
                { code: "th", name: "Thai" },
            ],
            passwordLoading: false,
            customerServiceItems: [
                {
                    key: "viber",
                    label: "Viber",
                    value: "09 XXX XXX XXX",
                    url: "viber://chat?number=%2B959XXXXXXXXX",
                    icon: "https://api.iconify.design/simple-icons:viber.svg?color=%237c3aed",
                },
                {
                    key: "telegram",
                    label: "Telegram",
                    value: "t.me/shwepaukkan",
                    url: "https://t.me/shwepaukkan",
                    icon: "https://api.iconify.design/simple-icons:telegram.svg?color=%230ea5e9",
                },
                {
                    key: "signal",
                    label: "Signal",
                    value: "signal.org",
                    url: "https://signal.org",
                    icon: "https://api.iconify.design/simple-icons:signal.svg?color=%232563eb",
                },
                {
                    key: "facebook",
                    label: "Facebook",
                    value: "facebook.com",
                    url: "https://www.facebook.com",
                    icon: "https://api.iconify.design/simple-icons:facebook.svg?color=%232563eb",
                },
                {
                    key: "phone",
                    label: "Phone Number",
                    value: "09 XXX XXX XXX",
                    url: "tel:09XXXXXXXXX",
                    icon: "https://api.iconify.design/mdi:phone.svg?color=%23111827",
                },
            ],
        };
    },
    computed: {
        ...mapGetters(["getToken"]),
        currentLocale() {
            return this.$i18n.locale;
        },
    },
    mixins: [CheckAuthMixin],
    methods: {
        ...mapMutations(["setLanguageCode"]),
        clickChangePass() {
            this.step = "changePassStepOne";
            this.title = "Change Password";
        },
        backBtn() {
            if (
                this.step == "changePassStepOne" ||
                this.step == "history" ||
                this.step == "changeLang" ||
                this.step == "feedback" ||
                this.step == "customerService" ||
                this.step == "contacts" ||
                this.step == "termsAndConditions"
            ) {
                this.step = "mainProfile";
                this.title = "Profile";
                return;
            }
            if (this.step == "mainProfile") {
                window.location.href = "/home";
            }
        },
        async getProfile() {
            let response = await getApiData({
                url: `api/get_profile`,
                token: this.getToken,
            });
            this.user_profile_data = response.data;
            this.contacts = response.data.contact;
        },
        async getTermsAndConditions() {
            let response = await getApiData({
                url: `api/get_term_and_condition`,
                token: this.getToken,
            });
            this.terms_and_conditions = response.data;
        },
        async sendFeedback() {
            if (!this.feedback) {
                this.$notify({
                    text: "Fill the feedback form!.",
                    type: "error",
                });
                return;
            }
            let url = "/api/feedbacks";
            let formData = new FormData();
            formData.append("text", this.feedback);
            this.loading = true;
            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            this.loading = false;
            if (response.success) {
                this.$notify({
                    text: "Successfully send feedback.",
                    type: "info",
                });
                this.feedback = "";
                this.step = "mainProfile";
                this.title = "Profile";
            } else {
                this.$notify({
                    text: response.message?.text,
                    type: "error",
                });
            }
        },
        dateFormat(date_time) {
            return moment(date_time).format("MM/DD/YYYY");
        },
        timeFormat(date_time) {
            return moment(date_time).format("hh:mm:ss A");
        },
        async handelChangePasswordStepOne() {
            if (
                this.new_password == "" ||
                this.current_password == "" ||
                this.new_password_confirmation == ""
            ) {
                this.$notify({
                    text: "Please fill all fields.",
                    type: "error",
                });
                return;
            }
            if (
                this.new_password.length < 6 ||
                this.current_password.length < 6 ||
                this.new_password_confirmation.length < 6
            ) {
                this.$notify({
                    text: "Password must be at least 6 characters long.",
                    type: "info",
                });
                return;
            }
            let url = "/api/change_password";
            let formData = new FormData();
            formData.append("current_password", this.current_password);
            formData.append("new_password", this.new_password);
            formData.append(
                "new_password_confirmation",
                this.new_password_confirmation,
            );
            this.passwordLoading = true;
            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            this.passwordLoading = false;
            if (response.success) {
                this.$notify({
                    text: response.message,
                    type: "info",
                });
                this.step = "mainProfile";
                this.title = "Profile";
            } else {
                this.$notify({
                    text:
                        response.message?.new_password ||
                        response.message?.current_password ||
                        response.message?.new_password_confirmation,
                    type: "error",
                });
            }
        },
        changeLocale(lang) {
            this.$i18n.locale = lang;
            this.setLanguageCode(lang);
            this.step = "mainProfile";
            this.$notify({
                text: "Language changed successfully.",
                type: "info",
            });
            return;
        },
        confirmChangeLocale() {
            if (!this.selectedLocale) {
                return;
            }
            this.changeLocale(this.selectedLocale);
        },
        openCustomerServiceLink(url) {
            if (!url) {
                return;
            }
            if (url.startsWith("http://") || url.startsWith("https://")) {
                window.open(url, "_blank");
                return;
            }
            window.location.href = url;
        },
        async logOut() {
            let url = "/api/logout";

            let response = await postApiData({
                url: url,
                token: this.getToken,
            });
            if (response.success) {
                localStorage.clear();

                this.$notify({
                    text: response.message,
                    type: "info",
                });
                window.location.href = "/home";
            } else {
            }
        },
    },

    mounted() {
        initTWE({ Modal, Ripple, Dropdown });
        this.getProfile();
        this.getTermsAndConditions();
        this.selectedLocale = this.currentLocale;
    },
};
</script>
