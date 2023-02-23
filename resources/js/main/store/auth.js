import moment from 'moment';
import router from '../router';
const AUTH_USER = 'auth_user';
const AUTH_TOKEN = 'auth_token';
const EXIPRES_KEY = 'expire_key';
const APP_SETTINGS_KEY = 'app_settings';
const GLOBAL_SETTINGS_KEY = 'global_settings';
const PER_PAGE_ITEM = 'per_page_item';
const ALL_LANGS = 'all_langs';
const ALL_CATEGORY = 'all_categories';
const SELECTED_LANG = 'selected_lang';
const PAGE_TITLE = 'page_title';
const DARK_THEME = 'dark_theme';
const ACTIVE_MODULES = 'active_modules';
const CSS_SETTINGS = 'css_settings';
const ADD_MENUS = 'add_menus';
const EMAIL_SETTING_VERIFIED = 'email_setting_verified';
const VISIBLE_SUBSCRIPTION_MODULES = 'visible_subscription_modules';
const REMAINING_CHARACTERS = 'remaining_characters';

moment.suppressDeprecationWarnings = true;

const getJSONFromLocalStorage = (key) => {
    const value = window.localStorage.getItem(key);

    if (value === 'undefined' || value === 'null' || value === undefined || value === null) {
        return null;
    }
    else {
        return JSON.parse(value);
    }
};

export default {
    namespaced: true,
    state() {
        return {
            user: getJSONFromLocalStorage(AUTH_USER),
            allCategories: getJSONFromLocalStorage(ALL_CATEGORY) || [],
            allLangs: getJSONFromLocalStorage(ALL_LANGS) || [],
            lang: window.localStorage.getItem(SELECTED_LANG) || "en",
            token: window.localStorage.getItem(AUTH_TOKEN) || null,
            expires: window.localStorage.getItem(EXIPRES_KEY) || null,
            globalSetting: getJSONFromLocalStorage(GLOBAL_SETTINGS_KEY),
            appSetting: getJSONFromLocalStorage(APP_SETTINGS_KEY),
            addMenus: getJSONFromLocalStorage(ADD_MENUS) || [],
            visibleSubscriptionModules: getJSONFromLocalStorage(VISIBLE_SUBSCRIPTION_MODULES) || [],
            perPage: window.localStorage.getItem(PER_PAGE_ITEM) || window.config.path,
            pageTitle: window.localStorage.getItem(PAGE_TITLE) || "",
            darkTheme: getJSONFromLocalStorage(DARK_THEME),
            activeModules: getJSONFromLocalStorage(ACTIVE_MODULES),
            cssSettings: getJSONFromLocalStorage(CSS_SETTINGS) || {
                leftRightPadding: '50px',
                headerMenuMode: 'vertical'
            },
            appChecking: true,
            emailSettingVerified: window.localStorage.getItem(EMAIL_SETTING_VERIFIED) || false,
            remainingCharacters: window.localStorage.getItem(REMAINING_CHARACTERS) || 0,
            menuCollapsed: window.innerWidth <= 991 ? true : false,
        }
    },

    mutations: {
        updateUser(state, user) {
            state.user = user;
            window.localStorage.setItem(AUTH_USER, JSON.stringify(user));
        },
        updateAppChecking(state, appChecking) {
            state.appChecking = appChecking;
        },
        updateRemainingCharacter(state, remainingCharacters) {
            window.localStorage.setItem(REMAINING_CHARACTERS, remainingCharacters);

            state.remainingCharacters = remainingCharacters;
        },
        updateToken(state, token) {
            state.token = token;
            window.localStorage.setItem(AUTH_TOKEN, token);

            // Setting up auth bearer token to axios
            axiosAdmin.defaults.headers.common["Authorization"] = `Bearer ${token}`
        },
        updateExpires(state, expires) {
            state.expires = new Date(expires);
            window.localStorage.setItem(EXIPRES_KEY, expires);
        },
        updateApp(state, appSetting) {
            state.appSetting = appSetting;
            window.localStorage.setItem(APP_SETTINGS_KEY, JSON.stringify(appSetting));

            // Changing favicon
            var faviconLink = document.querySelector("link[rel~='icon']");
            faviconLink.href = appSetting.small_light_logo_url;
        },
        updateGlobalSetting(state, globalSetting) {
            state.globalSetting = globalSetting;
            window.localStorage.setItem(GLOBAL_SETTINGS_KEY, JSON.stringify(globalSetting));

            // Changing favicon
            var faviconLink = document.querySelector("link[rel~='icon']");
            faviconLink.href = globalSetting.small_light_logo_url;
        },
        updateAddMenus(state, addMenus) {
            state.addMenus = addMenus;
            window.localStorage.setItem(ADD_MENUS, JSON.stringify(addMenus));
        },
        updatePerPage(state, perPage) {
            state.perPage = perPage;
            window.localStorage.setItem(PER_PAGE_ITEM, perPage);
        },
        updateLang(state, lang) {
            state.lang = lang;
            window.localStorage.setItem(SELECTED_LANG, lang);
        },
        updatePageTitle(state, pageTitle) {
            state.pageTitle = pageTitle;
            window.localStorage.setItem(PAGE_TITLE, pageTitle);

            if (state.appSetting !== null && state.appSetting !== undefined) {
                document.title = `${pageTitle} - ${state.appSetting.name}`;
            }
            else {
                document.title = `${pageTitle} - Stockify`;
            }

        },
        updateDarkTheme(state, isDarkTheme) {
            state.darkTheme = isDarkTheme;
            window.localStorage.setItem(DARK_THEME, isDarkTheme);
        },
        updateActiveModules(state, activeModules) {
            state.activeModules = activeModules;
            window.localStorage.setItem(ACTIVE_MODULES, JSON.stringify(activeModules));
        },
        updateCssSettings(state, cssSettings) {
            state.cssSettings = cssSettings;
            window.localStorage.setItem(CSS_SETTINGS, JSON.stringify(cssSettings));
        },
        updateAllLangs(state, allLangs) {
            state.allLangs = allLangs;
            window.localStorage.setItem(ALL_LANGS, JSON.stringify(allLangs));
        },
        updateAllCategories(state, allCategories) {
            state.allCategories = allCategories;
            window.localStorage.setItem(ALL_CATEGORY, JSON.stringify(allCategories));
        },
        updateMenuCollapsed(state, menuCollapsed) {
            state.menuCollapsed = menuCollapsed;
        },
        updateEmailVerifiedSetting(state, emailSettingVerified) {
            state.emailSettingVerified = emailSettingVerified;
            window.localStorage.setItem(EMAIL_SETTING_VERIFIED, emailSettingVerified);
        },
        updateVisibleSubscriptionModules(state, modules) {
            state.visibleSubscriptionModules = modules;
            window.localStorage.setItem(VISIBLE_SUBSCRIPTION_MODULES, JSON.stringify(modules));
        },
    },

    actions: {
        updateUser(context) {
            axiosAdmin.post(`/user`)
                .then(function (response) {
                    context.commit('updateUser', response.data.user);
                })
                .catch(function (error) {

                });
        },
        updateGlobalSetting(context) {
            axiosAdmin.get('/global-setting')
                .then(function (response) {
                    context.commit('updateGlobalSetting', response.data.global_setting);

                    // Changing favicon
                    var faviconLink = document.querySelector("link[rel~='icon']");
                    faviconLink.href = globalSetting.small_light_logo_url;
                })
                .catch(function (error) {

                });
        },
        updateRemainingCharacter(context) {
            axiosAdmin.get('/remaining-characters')
                .then(function (response) {
                    context.commit('updateRemainingCharacter', response.data.remaining_characters);
                })
                .catch(function (error) {

                });
        },
        updateApp(context) {
            axiosAdmin.get('/app')
                .then(function (response) {
                    context.commit('updateApp', response.data.app);
                    context.commit('updateEmailVerifiedSetting', response.data.email_setting_verified);

                    // Changing favicon
                    var faviconLink = document.querySelector("link[rel~='icon']");
                    faviconLink.href = response.data.app.small_light_logo_url;
                })
                .catch(function (error) {

                });
        },
        updateAllLangs(context) {
            axiosAdmin.get('/all-langs')
                .then(function (response) {
                    context.commit('updateAllLangs', response.data.langs);
                })
                .catch(function (error) {

                });
        },
        updateAllCategories(context) {
            axiosAdmin.get('/all-categories')
                .then(function (response) {
                    context.commit('updateAllCategories', response.data.categories);
                })
                .catch(function (error) {

                });
        },
        refreshToken(context) {
            const token = context.state.token;

            if (token !== "" && token !== "undefined" && token != 'null' && token != null) {
                axiosAdmin
                    .post(`/auth/refresh-token`)
                    .then(function (response) {
                        context.commit("updateUser", response.data.user);
                        context.commit("updateToken", response.data.token);
                        context.commit("updateExpires", response.data.expires_in);
                    })
                    .catch(function (error) { });
            }
        },
        logout(context) {
            axiosAdmin.post('/auth/logout')
                .then(function (response) {
                    window.sessionStorage.clear();

                    context.commit("updateUser", []);
                    context.commit('updateToken', null);
                    context.commit('updateExpires', null);
                    context.commit('updateEmailVerifiedSetting', 0);

                    router.push({
                        name: "admin.login"
                    });
                })
                .catch(function (error) {

                });
        },
        logoutToRootUrl(context) {
            axiosAdmin.post('/auth/logout')
                .then(function (response) {

                    context.commit("updateUser", []);
                    context.commit('updateToken', null);
                    context.commit('updateExpires', null);

                    window.location.href = window.config.path;
                })
                .catch(function (error) {

                });
        },
        updateVisibleSubscriptionModules(context) {
            axiosAdmin.post('/visible-subscription-modules')
                .then(function (response) {
                    context.commit('updateVisibleSubscriptionModules', response.data);
                })
                .catch(function (error) {

                });
        },
    },

    getters: {
        isLoggedIn: (state) => {
            if (state.token === null || state.token === '') {
                return false;
            }
            else {
                return moment(state.expires).isAfter(moment());
            }
        }
    }
}
