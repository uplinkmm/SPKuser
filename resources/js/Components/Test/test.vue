<template lang="">
    <div class="mt-8">
        <button @click="getBalance" class="ml-8 p-3 bg-slate-600">
            Get Balance
        </button>
    </div>
</template>
<script>
import CryptoJS from "crypto-js";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import moment from "moment";
import { mapGetters, mapMutations } from "vuex";

export default {
    data() {
        return {
            OperatorCode: "",
            SecretKey: "",
            MethodName: "getbalance",
        };
    },
    computed: {
        ...mapGetters(["getToken", "getUser"]),
        sign() {
            const requestDateTime = moment().format("yyyy-MM-DD HH:mm:ss");
            // Concatenate the values
            const stringToHash =
                this.OperatorCode +
                requestDateTime +
                this.MethodName +
                this.SecretKey;
            // Generate the MD5 hash
            console.log(stringToHash);
            const hash = CryptoJS.MD5(stringToHash).toString();
            console.log(hash);
            return hash;
        },
    },
    methods: {
        async getBalance() {
            let url = "/api/Seamless/GetBalance";
            let formData = new FormData();
            const requestDateTime = moment().format("yyyyMMDDHHmmss");
            var randomNumber = Math.floor(Math.random() * 1000) + 1;

            formData.append("MemberName", this.getUser.id);
            formData.append("OperatorCode", this.OperatorCode);
            formData.append("ProductID", "1009");
            formData.append("MessageID", randomNumber + requestDateTime);
            formData.append("RequestTime", requestDateTime);
            formData.append("Sign", this.sign);

            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            console.log(response);
        },
    },
    mounted() {
        this.OperatorCode = import.meta.env.VITE_OPERATOR_ID;
        this.SecretKey = import.meta.env.VITE_SECRET_KEY;
        console.log(import.meta.env.VITE_SECRET_KEY);
    },
};
</script>
<style lang=""></style>
