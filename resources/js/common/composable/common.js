import { computed } from "vue";
import moment from "moment";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { forEach, includes } from "lodash-es";
import { checkUserPermission } from "../scripts/functions";
import dayjs from 'dayjs';

moment.suppressDeprecationWarnings = true;
var utc = require('dayjs/plugin/utc')
var timezone = require('dayjs/plugin/timezone');
dayjs.extend(utc);
dayjs.extend(timezone);

const common = () => {
    const store = useStore();
    const { t } = useI18n();
    const appType = window.config.app_type;
    const downloadLangCsvUrl = window.config.download_lang_csv_url;
    const menuCollapsed = computed(() => store.state.auth.menuCollapsed);
    const cssSettings = computed(() => store.state.auth.cssSettings);
    const appModules = computed(() => store.state.auth.activeModules);
    const visibleSubscriptionModules = computed(() => store.state.auth.visibleSubscriptionModules);
    const globalSetting = computed(() => store.state.auth.globalSetting);
    const appSetting = computed(() => store.state.auth.appSetting);
    const addMenus = computed(() => store.state.auth.addMenus);
    const selectedLang = computed(() => store.state.auth.lang);
    const user = computed(() => store.state.auth.user);
    const allCategories = computed(() => store.state.auth.allCategories);
    const remainingCharacters = computed(() => store.state.auth.remainingCharacters);

    const statusColors = {
        enabled: "success",
        disabled: "error",
    };

    const userStatus = [
        {
            key: "enabled",
            value: t("common.enabled")
        },
        {
            key: "disabled",
            value: t("common.disabled")
        }
    ];

    const disabledDate = (current) => {
        // Can not select days before today and today
        return current && current > moment().endOf("day");
    };

    const dayjsObject = (date) => {
        if (date == undefined) {
            return dayjs()
                .tz(appSetting.value.timezone);
        } else {
            return dayjs(date)
                .tz(appSetting.value.timezone);
        }
    }

    const formatDate = (date) => {
        if (date == undefined) {
            return dayjs()
                .tz(appSetting.value.timezone)
                .format(
                    `${appSetting.value.date_format}`
                )
        } else {
            return dayjs(date)
                .tz(appSetting.value.timezone)
                .format(
                    `${appSetting.value.date_format}`
                )
        }
    }

    const formatDateTime = (dateTime) => {
        if (dateTime == undefined) {
            return dayjs()
                .tz(appSetting.value.timezone)
                .format(
                    `${appSetting.value.date_format} ${appSetting.value.time_format}`
                )
        } else {
            return dayjs(dateTime)
                .tz(appSetting.value.timezone)
                .format(
                    `${appSetting.value.date_format} ${appSetting.value.time_format}`
                )
        }
    }

    const formatAmount = (amount) => {
        return parseFloat(parseFloat(amount).toFixed(2));
    };

    const formatAmountCurrency = (amount) => {
        const newAmount = parseFloat(Math.abs(amount)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if (appSetting.value.currency.position == "front") {
            var newAmountString = `${appSetting.value.currency.symbol}${newAmount}`;
        } else {
            var newAmountString = `${newAmount}${appSetting.value.currency.symbol}`;
        }

        return amount < 0 ? `- ${newAmountString}` : newAmountString;
    };

    const formatAmountUsingCurrencyObject = (amount, currency) => {
        const newAmount = parseFloat(Math.abs(amount)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if (currency.position == "front") {
            var newAmountString = `${currency.symbol}${newAmount}`;
        } else {
            var newAmountString = `${newAmount}${currency.symbol}`;
        }

        return amount < 0 ? `- ${newAmountString}` : newAmountString;
    };

    const calculateFilterString = (filters) => {
        var filterString = "";

        forEach(filters, (filterValue, filterKey) => {
            if (filterValue != undefined) {
                filterString += `${filterKey} eq "${filterValue}" and `;
            }
        })

        if (filterString.length > 0) {
            filterString = filterString.substring(0, filterString.length - 4);
        }

        return filterString;
    }

    const checkPermission = (permissionName) => checkUserPermission(permissionName, user.value);

    const updatePageTitle = (pageName) => {
        store.commit("auth/updatePageTitle", t(`menu.${pageName}`));
    }

    const permsArray = computed(() => {
        const permsArrayList = user && user.value && user.value.role ? [user.value.role.name] : [];

        if (user && user.value && user.value.role) {
            forEach(user.value.role.perms, (permission) => {
                permsArrayList.push(permission.name);
            });
        }

        return permsArrayList;
    });

    const slugify = (text) => {
        return text
            .toString()
            .toLowerCase()
            .replace(/\s+/g, "-") // Replace spaces with -
            .replace(/[^\w\-]+/g, "") // Remove all non-word chars
            .replace(/\-\-+/g, "-") // Replace multiple - with single -
            .replace(/^-+/, "") // Trim - from start of text
            .replace(/-+$/, ""); // Trim - from end of text
    };

    const convertToPositive = (amount) => {
        return amount < 0 ? amount * -1 : amount;
    }

    const willSubscriptionModuleVisible = (moduleName) => {
        if (appType == 'non-saas') {
            return true;
        } else {
            if (appSetting.value.subscription_plan && appSetting.value.subscription_plan.modules) {
                return includes(appSetting.value.subscription_plan.modules, moduleName);
            } else {
                return false;
            }
        }
    }

    return {
        menuCollapsed,
        appSetting,
        appType,
        addMenus,
        selectedLang,
        user,
        checkPermission,
        permsArray,
        statusColors,
        userStatus,
        allCategories,

        disabledDate,
        formatAmount,
        formatAmountCurrency,
        formatAmountUsingCurrencyObject,
        convertToPositive,

        calculateFilterString,
        updatePageTitle,

        downloadLangCsvUrl,
        appModules,
        dayjs,
        formatDate,
        formatDateTime,
        dayjsObject,
        slugify,

        cssSettings,
        globalSetting,

        willSubscriptionModuleVisible,
        visibleSubscriptionModules,

        remainingCharacters,
    };
}

export default common;
