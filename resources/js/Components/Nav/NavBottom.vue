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
          class="block w-full sm:w-3/12 sm:min-w-[480px] mx-auto rounded-none shadow-lg fixed left-0 right-0 bottom-0 z-50 bg-black border-t border-[#C67D06]"
      >
          <div class="grid grid-cols-4 px-[2%] pt-1">
              <div class="text-center">
                  <a
                      href="/home"
                      class="py-3 text-xs w-full relative flex flex-col text-[#E5B80B]"
                  >
                      <i class="fal fa-home-lg-alt block pb-1"></i>
                       {{ $t('Home')}}
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
              <div class=" text-center">
                  <a
                      href="/wallet"
                      class="py-3 text-xs w-full relative flex flex-col text-[#E5B80B]"
                  >
                      <i class="fal fa-wallet block pb-1"></i>
                       {{ $t('Wallet') }}
                  </a>
              </div>
              <div class=" text-center">
                <a
                    href="/notifications"
                    class="py-3 text-xs w-full relative flex flex-col text-[#E5B80B]"
                >
                    <i class="fal fa-bell block pb-1"></i>
                    {{$t("Notification")}}
                     
                </a>
              </div>
              <div class=" text-center">
                  <a
                      href="/profile"
                      class="py-3 text-xs w-full relative flex flex-col text-[#E5B80B]"
                  >
                      <i class="fal fa-user-alt block pb-1"></i>
                       {{$t("Profile")}}
                  </a>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {};
</script>
<style lang=""></style>
