import "./bootstrap";
import "../css/app.css";

///////////// Tailwind section //////////////
import {
    Collapse,
    Carousel,
    initTWE,
    Modal,
    Ripple,
    Dropdown,
    Input,
    Tab,
} from "tw-elements";
initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });

//////////////................/////////////////

import { createApp } from "vue/dist/vue.esm-bundler";
import { store } from "./Store";
import Notifications from "@kyvg/vue3-notification";
import firebase from "firebase/compat/app";
import "firebase/compat/messaging";
const firebaseConfig = {
    apiKey: import.meta.env.VITE_GOOGLE_API_KEY,
    authDomain: import.meta.env.VITE_GOOGLE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_GOOGLE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_GOOGLE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_GOOGLE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_GOOGLE_APP_ID,
    measurementId: import.meta.env.VITE_GOOGLE_MEASUREMENT_ID,
};

const app = createApp({});
firebase.initializeApp(firebaseConfig);
import i18n from "./i18n"; // Import the i18n configuration

import LoginRegister from "./Components/Auth/LoginRegister.vue";
import LoginComponent from "./Components/Auth/LoginComponent.vue";
import RegisterComponent from "./Components/Auth/RegisterComponent.vue";
import WalletComponent from "./Components/Wallet/WalletComponent.vue";
import MoneyInComponent from "./Components/MoneyIn/MoneyInComponent.vue";
import MoneyOutComponent from "./Components/MoneyOut/MoneyOutComponent.vue";
import Dbetting from "./Components/Betting/2Dbetting.vue";
import D3betting from "./Components/Betting/3Dbetting.vue";
import NotificationsComponent from "./Components/Notifications/Notifications.vue";
import BetHistories from "./Components/History/BetHistories.vue";
import Home from "./Components/Home/Home.vue";
import ProfileComponent from "./Components/Profile/ProfileComponent.vue";
import TwodAnalysisComponent from "./Components/Twod/TwodAnalysisComponent.vue";
import TwodCalendarComponent from "./Components/Twod/TwodCalendarComponent.vue";
import TwodDreamNumberComponent from "./Components/Twod/TwodDreamNumberComponent.vue";
import TwodLiveComponent from "./Components/Twod/TwodLiveComponent.vue";
import TwodProAnalysisComponent from "./Components/Twod/TwodProAnalysisComponent.vue";
import ThreedLiveComponent from "./Components/Threed/ThreedLiveComponent.vue";
import ThreedCalendarComponent from "./Components/Threed/ThreedCalendarComponent.vue";
import ThreedAnalysisComponent from "./Components/Threed/ThreedAnalysisComponent.vue";
import DepositWithdrawalHistories from "./Components/History/DepositWithdrawalHistories.vue";
import WinnerLists from "./Components/Betting/WinnerLists.vue";
import SocialPhoneNumber from "./Components/Auth/SocialPhoneNumber.vue";
import NavBottom from "./Components/Nav/NavBottom.vue";
import LotteryHistories from "./Components/History/LotteryHistories.vue";
import SlotsComponent from "./Components/Slots/SlotsComponent.vue";
import Test from "./Components/Test/test.vue";
import SlotsGames from "./Components/Slots/SlotsGames.vue";
import SlotsProviders from "./Components/Slots/SlotsProviders.vue";
import LotteryComponent from "./Components/Lottery/LotteryComponent.vue";
import BuffaloRooms from "./Components/Buffalo/BuffaloRooms.vue";

app.component("Test", Test);
app.component("SocialPhoneNumber", SocialPhoneNumber);
app.component("LoginRegister", LoginRegister);
app.component("LoginComponent", LoginComponent);
app.component("RegisterComponent", RegisterComponent);
app.component("WalletComponent", WalletComponent);
app.component("MoneyInComponent", MoneyInComponent);
app.component("MoneyOutComponent", MoneyOutComponent);
app.component("Dbetting", Dbetting);
app.component("D3betting", D3betting);
app.component("NotificationsComponent", NotificationsComponent);
app.component("BetHistories", BetHistories);
app.component("Home", Home);
app.component("ProfileComponent", ProfileComponent);
app.component("TwodAnalysisComponent", TwodAnalysisComponent);
app.component("TwodCalendarComponent", TwodCalendarComponent);
app.component("TwodDreamNumberComponent", TwodDreamNumberComponent);
app.component("TwodLiveComponent", TwodLiveComponent);
app.component("TwodProAnalysisComponent", TwodProAnalysisComponent);
app.component("ThreedLiveComponent", ThreedLiveComponent);
app.component("ThreedCalendarComponent", ThreedCalendarComponent);
app.component("ThreedAnalysisComponent", ThreedAnalysisComponent);
app.component("DepositWithdrawalHistories", DepositWithdrawalHistories);
app.component("WinnerLists", WinnerLists);
app.component("NavBottom", NavBottom);
app.component("LotteryHistories", LotteryHistories);
app.component("SlotsComponent", SlotsComponent);
app.component("SlotsGames", SlotsGames);
app.component("SlotsProviders", SlotsProviders);
app.component("LotteryComponent", LotteryComponent);
app.component("BuffaloRooms", BuffaloRooms);

app.use(store);
app.use(Notifications);
app.use(i18n);
app.mount("#app");
