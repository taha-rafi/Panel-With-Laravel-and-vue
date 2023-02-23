import { ref } from "vue";
import { useI18n } from "vue-i18n";
import { forEach } from "lodash-es";
import { message, notification } from "ant-design-vue";
import common from "../composable/common";

const api = () => {
    const loading = ref(false);
    const rules = ref({});
    const { t } = useI18n();
    const { appSetting } = common();

    const addEditRequestAdmin = (configObject) => {
        loading.value = true;
        const { url, data, success } = configObject;
        var formData = {};

        // Replace undefined values to null
        forEach(data, function (value, key) {
            if (value == undefined) {
                formData[key] = null;
            } else {
                formData[key] = value;
            }
        });

        axiosAdmin
            .post(url, formData)
            .then(response => {

                // Toastr Notificaiton
                if (configObject.successMessage) {
                    notification.success({
                        placement: appSetting.value.rtl ? "bottomLeft" : "bottomRight",
                        message: t("common.success"),
                        description: configObject.successMessage
                    });
                }

                success(response.data);
                loading.value = false;
                rules.value = {};
            })
            .catch(errorResponse => {
                console.log(errorResponse, 'error');
                var err = errorResponse.data;
                const errorCode = errorResponse.status;
                var errorRules = {};

                if (errorCode == 422) {
                    if (err.error && typeof err.error.details != "undefined") {
                        var keys = Object.keys(err.error.details);
                        for (var i = 0; i < keys.length; i++) {
                            // Escape dot that comes with error in array fields
                            var key = keys[i].replace(".", "\\.");

                            errorRules[key] = {
                                required: true,
                                message: err.error.details[keys[i]][0],
                            };
                        }
                    }

                    rules.value = errorRules;
                    message.error(t("common.fix_errors"));
                }

                if (err && err.message) {
                    message.error(err.message);
                    err = {
                        error: {
                            ...err
                        }
                    }
                }

                if (configObject.error) {
                    configObject.error(err);
                }

                loading.value = false;
            });
    }

    const addEditFileRequestAdmin = (configObject) => {
        loading.value = true;
        const { url, data, success } = configObject;
        const formData = new FormData();

        // Replace undefined values to null
        forEach(data, function (value, key) {
            if (value == undefined) {
                formData.append(key, null);
            } else {
                formData.append(key, value.originFileObj);
            }
        });

        axiosAdmin
            .post(url, formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
            .then(response => {
                // Toastr Notificaiton
                if (configObject.successMessage) {
                    notification.success({
                        placement: appSetting.value.rtl ? "bottomLeft" : "bottomRight",
                        message: t("common.success"),
                        description: configObject.successMessage
                    });
                }

                success(response.data);
                loading.value = false;
                rules.value = {};
            })
            .catch(errorResponse => {
                var err = errorResponse.data;
                const errorCode = errorResponse.status;
                var errorRules = {};

                if (errorCode == 422) {
                    if (err.error && typeof err.error.details != "undefined") {
                        var keys = Object.keys(err.error.details);
                        for (var i = 0; i < keys.length; i++) {
                            // Escape dot that comes with error in array fields
                            var key = keys[i].replace(".", "\\.");

                            errorRules[key] = {
                                required: true,
                                message: err.error.details[keys[i]][0],
                            };
                        }
                    }

                    rules.value = errorRules;
                    message.error(t("common.fix_errors"));
                }

                if (err && err.message) {
                    message.error(err.message);
                    err = {
                        error: {
                            ...err
                        }
                    }
                }

                if (configObject.error) {
                    configObject.error(err);
                }

                loading.value = false;
            });
    }

    return {
        loading,
        rules,
        addEditRequestAdmin,
        addEditFileRequestAdmin
    };
}

export default api;
