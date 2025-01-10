<template>
  <main
      class="w-full h-full min-h-[60vh] mx-auto px-8 pb-2 flex flex-row justify-center items-center relative"
  >
      <div class="">
            <p class="mb-8 text-center font-semibold primary-text">Forgot Password?</p>
          <div class="mb-4">
              <label
                  class="flex w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white"
              >
                  <input
                      type="text"
                      id="phone_number"
                      v-model="phone_number"
                      :placeholder="$t('Phone Number')"
                      class="focus:ring-0 focus:shadow-none focus:outline-none w-full"
                  />
                  <button
                      class="text-xs border-l border-gray-400 pl-1 py-1 flex-shrink-0"
                      @click="getOtp"
                  >
                      Get OTP
                  </button>
              </label>
          </div>
          <div class="mb-4">
              <input
                  type="text"
                  id="otp"
                  v-model="otp"
                  placeholder="OTP"
                  :disabled="!otpRequested"
                  class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
              />
          </div>

          <div class="mb-4">
              <input
                  type="password"
                  id="password"
                  v-model="password"
                  placeholder="Password"
                  :disabled="!otpRequested"
                  class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
              />
          </div>

          <div class="mb-8">
              <input
                  type="password"
                  id="password_confirmation"
                  v-model="password_confirmation"
                  placeholder="Confirm Password"
                  :disabled="!otpRequested"
                  class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
              />
          </div>

          <div>
              <button
                  @click="forgotPassword"
                  :disabled="!otpRequested"
                  class="block w-full py-2.5 px-2 text-sm rounded-md bg-[#000] border border-[#E4BD1B] text-white focus:ring-0 focus:shadow-none focus:outline-none"
              >
                  Confirm
              </button>
          </div>
      </div>
      <form method="POST" id="signin-form" ref="signinForm" action="/login">
          <input type="hidden" v-model="csrfToken" name="_token" />
          <input type="hidden" v-model="phone_number" name="phone_number" />
          <input type="hidden" v-model="password" name="password" />
          <input type="hidden" name="remember" value="true" />
      </form>
  </main>
</template>

<script>
import { mapMutations } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import fcmMixin from "../../mixins/fcmMixin";

export default {
  name: "RegisterComponent",
  data() {
      return {
          token: null,
          csrfToken: null,

          user_name: null,
          phone_number: null,
          otp: null,
          password: null,
          password_confirmation: null,
          code:null,
          remember: true,
          otpRequested: false,
      };
  },
  props: {
      props: {
          fcmToken: {},
      },
  },
  // mixins: [fcmMixin],

  methods: {
      ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

      async getOtp() {
          if ( !this.phone_number) {
              this.$notify({
                  text: "You forgot to phone number",
                  type: "warn",
              });

              return 1;
          }
          let formData = new FormData();
          formData.append("phone_number", this.phone_number);
          let url = `/api/get_code`;
          let response = await postApiData({ url: url, form_data: formData });
          if (response.success) {
              this.otpRequested = true;
              this.$notify({
                  text: response.message,
                  type: "info",
              });
          } else {
              this.$notify({
                  text: response.message,
                  type: "error",
              });
          }
      },

      async forgotPassword() {
          if (!this.otp || !this.password || !this.password_confirmation) {
              this.$notify({
                  text: "All field must be entered",
                  type: "warn",
              });
              return 1;
          }
          if (this.password != this.password_confirmation) {
              this.$notify({
                  text: "Confirm password not match",
                  type: "warn",
              });
              return 1;
          }
          if (this.password.length < 6 || this.password_confirmation.length < 6) {
                this.$notify({
                    text: "Password must be at least 6 characters long.",
                    type: "info",
                });
                return;
            }

          let url = "/api/forget_password";
          let formData = new FormData();
          formData.append("phone_number", this.phone_number);
          formData.append("password", this.password);
          formData.append("password_confirmation", this.password_confirmation);
          formData.append("otp", this.otp);
          formData.append("fcm_token", this.fcmToken); //from mixin

          let response = await postApiData({ url: url, form_data: formData });

          if (response.success) {
              this.$notify({
                  text: response.message,
                  type: "info",
              });
              this.token = response.data.token;
              this.setToken(this.token);
              let user = response.data.user;
              this.setUser(user);
              this.$refs.signinForm.submit();

              return true;
          } else {
              this.$notify({
                  text: response.message,
                  type: "error",
              });
              return false;
          }
      },
  },

  created() {
      this.csrfToken = $('meta[name="csrf-token"]').attr("content");
      this.setCsrfToken(this.csrfToken);
  },
};
</script>
