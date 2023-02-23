<template>
    <a-form layout="vertical">
        <a-row :gutter="16">
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <a-form-item
                    :label="$t('offline_request.payment_mode')"
                    name="offline_payment_mode_id"
                    :help="
                        rules.offline_payment_mode_id
                            ? rules.offline_payment_mode_id.message
                            : null
                    "
                    :validateStatus="rules.offline_payment_mode_id ? 'error' : null"
                    class="required"
                >
                    <a-select
                        v-model:value="formData.offline_payment_mode_id"
                        :placeholder="
                            $t('common.select_default_text', [
                                $t('offline_request.payment_mode'),
                            ])
                        "
                        :allowClear="true"
                    >
                        <a-select-option
                            v-for="allMethod in allMethods"
                            :key="allMethod.xid"
                            :value="allMethod.xid"
                        >
                            {{ allMethod.name }}
                        </a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>
        </a-row>

        <a-row
            :gutter="16"
            v-if="selectedOfflineMethod && selectedOfflineMethod.description"
        >
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <a-form-item :label="$t('offline_request.offline_account_details')">
                    <span class="ant-form-text" style="white-space: pre">
                        {{ selectedOfflineMethod.description }}
                    </span>
                </a-form-item>
            </a-col>
        </a-row>

        <a-row :gutter="16">
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <a-form-item
                    :label="$t('offline_request.proof_document')"
                    name="proof_document"
                    :help="rules.proof_document ? rules.proof_document.message : null"
                    :validateStatus="rules.proof_document ? 'error' : null"
                    class="required"
                >
                    <UploadFile
                        :acceptFormat="'image/*,.pdf'"
                        :formData="formData"
                        folder="offline-requests"
                        uploadField="proof_document"
                        @onFileUploaded="
                            (file) => {
                                formData.proof_document = file.file;
                                formData.proof_document_url = file.file_url;
                            }
                        "
                    />
                </a-form-item>
            </a-col>
        </a-row>

        <a-row :gutter="16">
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <a-form-item
                    :label="$t('offline_request.submit_description')"
                    name="submit_description"
                    :help="
                        rules.submit_description ? rules.submit_description.message : null
                    "
                    :validateStatus="rules.submit_description ? 'error' : null"
                    class="required"
                >
                    <a-textarea
                        v-model:value="formData.submit_description"
                        :placeholder="
                            $t('common.placeholder_default_text', [
                                $t('offline_request.submit_description'),
                            ])
                        "
                        :rows="4"
                    />
                </a-form-item>
            </a-col>
        </a-row>

        <a-row :gutter="16" class="mt-20">
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <a-button
                    type="primary"
                    @click="pay"
                    :loading="loading"
                    :disabled="!(selectedOfflineMethod && selectedOfflineMethod.xid)"
                    block
                >
                    {{ $t("payment_settings.complete_transcation") }}
                </a-button>
            </a-col>
        </a-row>
    </a-form>
</template>

<script>
import { defineComponent, ref, computed } from "vue";
import { find } from "lodash-es";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../../common/composable/apiAdmin";
import UploadFile from "../../../../common/core/ui/file/UploadFile.vue";

export default {
    props: ["allMethods", "subscribePlan", "planType"],
    components: { UploadFile },
    setup(props, { emit }) {
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const { t } = useI18n();
        const formData = ref({
            offline_payment_mode_id: undefined,
            proof_document: undefined,
            proof_document_url: undefined,
            subscription_plan_id: props.subscribePlan.xid,
            plan_type: props.planType,
        });

        const selectedOfflineMethod = computed(() => {
            return find(props.allMethods, [
                "xid",
                formData.value.offline_payment_mode_id,
            ]);
        });

        const pay = () => {
            addEditRequestAdmin({
                url: `submit-offline-request`,
                data: formData.value,
                successMessage: t("offline_request.request_submited_successfully"),
                success: (res) => {
                    emit("success", true);
                },
            });
        };

        return {
            loading,
            rules,
            formData,

            selectedOfflineMethod,
            pay,
        };
    },
};
</script>

<style></style>
