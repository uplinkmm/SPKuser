<template>
  <notifications position="top center" />
  <div class="w-full h-full bg-gray-200">
      <main
          class="w-full h-full min-h-[80vh] lg:w-7/12 mx-auto px-8 bg-white pb-2 flex flex-row justify-center items-center relative"
      >
          <img
              src="../../../../public/img/bell-dynamic-color.png"
              class="absolute top-0 left-0"
          />
          <img
              src="../../../../public/img/bulb-front-color.png"
              class="absolute bottom-0 right-0"
          />
          <div class="flex justify-center items-center flex-col min-h-screen">
              <div class="w-full max-w-md">
                  <div class="" id="tabs-twoD">
                      <main
                          class="w-full h-full min-h-[40vh] mx-auto px-8 bg-white pb-2 flex flex-row justify-center items-center relative"
                      >
                          <div
                              v-if="JSON.parse(customer).is_verified == 0"
                              class=""
                              @keyup.enter="login"
                          >
                              <div class="mb-4">
                                  <input
                                      type="text"
                                      id="phone_number"
                                      v-model="phone_number"
                                      :placeholder="$t('Phone Number')"
                                      class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                                  />
                              </div>
                              <div class="mb-4">
                                  <input
                                      type="text"
                                      id="agent_code"
                                      v-model="code"
                                      placeholder="Agent Code(Optional)"
                                      class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                                  />
                              </div>
                              <div class="mb-4">
                                  <button
                                      @click="login"
                                      class="block w-full py-2 px-2 text-sm rounded-md bg-[#3194FE] text-white focus:ring-0 focus:shadow-none"
                                  >
                                      Login
                                  </button>
                              </div>
                          </div>
                          <div v-else>Loading....</div>
                          <!-- <form
                              method="POST"
                              id="signin-form"
                              ref="signinForm"
                              action="/login"
                          >
                              <input
                                  type="hidden"
                                  v-model="csrfToken"
                                  name="_token"
                              />
                              <input
                                  type="hidden"
                                  v-model="phone_number"
                                  name="phone_number"
                              />
                              <input
                                  type="hidden"
                                  v-model="password"
                                  name="password"
                              />
                          </form> -->
                      </main>
                  </div>
              </div>
          </div>
      </main>
  </div>
</template>

<script>
import { mapMutations } from "vuex";
import { postApiData } from "../../utilities/ajax-helpers";
import fcmMixin from "../../mixins/fcmMixin";
export default {
  data() {
      return {
          token: null,
          csrfToken: null,
          phone_number: null,
          code:null
      };
  },
  props: {
      customer: {},
  },
  mixins: [fcmMixin],

  methods: {
      ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

      async login() {
          var customer = JSON.parse(this.customer);
          let url = "/api/social_register";
          let formData = new FormData();
          if (customer.is_verified == 1) {
              formData.append("phone_number", customer.phone_number);
          } else {
              formData.append("phone_number", this.phone_number);
          }
          formData.append("code", this.code);

          formData.append("name", customer.name);
          formData.append("is_verified", customer.is_verified);
          formData.append("provider_name", customer.provider_name);
          formData.append("provider_id", customer.provider_id);
          formData.append("email", customer.email);
          formData.append("fcm_token", this.fcmToken); //from mixin

          let response = await postApiData({ url: url, form_data: formData });
          if (response.data) {
              this.$notify({
                  text: response.message,
                  type: "info",
              });
              this.token = response.data.token;
              this.setToken(this.token);
              let user = response.data.user;
              this.setUser(user);
              // this.$refs.signinForm.submit();
              // return true;
              window.location.href = "/";
          } else {
              this.$notify({
                  text: response.message,
                  type: "error",
              });

              return false;
          }
      },
  },
  watch: {
      customer: {
          deep: true, // watches the entire customer object for changes
          immediate: true, // runs the watcher right after component creation
          handler(newCustomer) {
              if (newCustomer && JSON.parse(newCustomer).is_verified === 1) {
                  this.login(); // no need for await inside the watcher
              }
          },
      },
  },
  async created() {
      this.csrfToken = $('meta[name="csrf-token"]').attr("content");
      this.setCsrfToken(this.csrfToken);
  },
};
</script>
