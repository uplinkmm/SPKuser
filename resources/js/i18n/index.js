// resources/js/i18n.js

import { createI18n } from "vue-i18n";
import en from "./../lang/en.json";
import mm from "./../lang/mm.json";
import cn from "./../lang/cn.json";
import th from "./../lang/th.json";

import { store } from "./../Store/index";
const defaultLocale = store.getters.languageCode;
const messages = {
    en: en,
    mm: mm,
    cn: cn,
    th: th,
};

const i18n = createI18n({
    locale: defaultLocale,
    fallbackLocale: "mm",
    messages,
});

export default i18n;
