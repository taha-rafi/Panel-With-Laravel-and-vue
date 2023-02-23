<template>
    <a-drawer
        :title="pageTitle"
        :width="drawerWidth"
        :visible="visible"
        :body-style="{ paddingBottom: '80px' }"
        :footer-style="{ textAlign: 'right' }"
        :maskClosable="false"
        @close="onClose"
    >
        <a-form layout="vertical">
            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('subscription_plans.name')"
                        name="name"
                        :help="rules.name ? rules.name.message : null"
                        :validateStatus="rules.name ? 'error' : null"
                        class="required"
                    >
                        <a-input
                            v-model:value="formData.name"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('subscription_plans.name'),
                                ])
                            "
                        />
                    </a-form-item>
                </a-col>
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('subscription_plans.max_characters')"
                        name="max_characters"
                        :help="rules.max_characters ? rules.max_characters.message : null"
                        :validateStatus="rules.max_characters ? 'error' : null"
                        class="required"
                    >
                        <a-input-number
                            v-model:value="formData.max_characters"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('subscription_plans.max_characters'),
                                ])
                            "
                            :style="{ width: '100%' }"
                        />
                    </a-form-item>
                </a-col>
            </a-row>

            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('subscription_plans.description')"
                        name="description"
                        :help="rules.description ? rules.description.message : null"
                        :validateStatus="rules.description ? 'error' : null"
                        class="required"
                    >
                        <a-textarea
                            v-model:value="formData.description"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('subscription_plans.description'),
                                ])
                            "
                            :rows="4"
                        />
                    </a-form-item>
                </a-col>
            </a-row>

            <a-row :gutter="16" v-if="addEditType == 'edit' && data.default == 'trial'">
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('subscription_plans.trial_duration')"
                        name="duration"
                        :help="rules.duration ? rules.duration.message : null"
                        :validateStatus="rules.duration ? 'error' : null"
                        class="required"
                    >
                        <a-input-number
                            v-model:value="formData.duration"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('subscription_plans.trial_duration'),
                                ])
                            "
                            :addon-after="$t('subscription_plans.days')"
                            :style="{ width: '100%' }"
                        />
                    </a-form-item>
                </a-col>
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('subscription_plans.notify_before')"
                        name="notify_before"
                        :help="rules.notify_before ? rules.notify_before.message : null"
                        :validateStatus="rules.notify_before ? 'error' : null"
                        class="required"
                    >
                        <a-input-number
                            v-model:value="formData.notify_before"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('subscription_plans.notify_before'),
                                ])
                            "
                            :addon-after="$t('subscription_plans.days')"
                            :style="{ width: '100%' }"
                        />
                    </a-form-item>
                </a-col>
            </a-row>

            <div
                v-if="
                    addEditType == 'add' ||
                    (addEditType == 'edit' && data.default == 'no')
                "
            >
                <a-row :gutter="16">
                    <a-col :xs="24" :sm="24" :md="24" :lg="24">
                        <a-form-item
                            :label="$t('subscription_plans.is_popular_plan')"
                            name="is_popular"
                            :help="rules.is_popular ? rules.is_popular.message : null"
                            :validateStatus="rules.is_popular ? 'error' : null"
                        >
                            <a-switch
                                v-model:checked="formData.is_popular"
                                :checkedValue="1"
                                :unCheckedValue="0"
                            />
                        </a-form-item>
                    </a-col>
                </a-row>

                <FormItemHeading
                    v-if="
                        addEditType == 'add' ||
                        (addEditType == 'edit' && data.default == 'no')
                    "
                >
                    {{ $t("subscription_plans.pricing_details") }}
                </FormItemHeading>

                <a-row :gutter="16">
                    <a-col :xs="24" :sm="24" :md="12" :lg="12">
                        <a-form-item
                            :label="$t('subscription_plans.monthly_price')"
                            name="monthly_price"
                            :help="
                                rules.monthly_price ? rules.monthly_price.message : null
                            "
                            :validateStatus="rules.monthly_price ? 'error' : null"
                            class="required"
                        >
                            <a-input-number
                                v-model:value="formData.monthly_price"
                                :placeholder="
                                    $t('common.placeholder_default_text', [
                                        $t('subscription_plans.monthly_price'),
                                    ])
                                "
                                :min="0"
                                :style="{ width: '100%' }"
                            >
                                <template #addonBefore>
                                    {{ appSetting.currency.symbol }}
                                </template>
                            </a-input-number>
                        </a-form-item>
                    </a-col>
                    <a-col :xs="24" :sm="24" :md="12" :lg="12">
                        <a-form-item
                            :label="$t('subscription_plans.annual_price')"
                            name="annual_price"
                            :help="rules.annual_price ? rules.annual_price.message : null"
                            :validateStatus="rules.annual_price ? 'error' : null"
                            class="required"
                        >
                            <a-input-number
                                v-model:value="formData.annual_price"
                                :placeholder="
                                    $t('common.placeholder_default_text', [
                                        $t('subscription_plans.annual_price'),
                                    ])
                                "
                                :min="0"
                                :style="{ width: '100%' }"
                            >
                                <template #addonBefore>
                                    {{ appSetting.currency.symbol }}
                                </template>
                            </a-input-number>
                        </a-form-item>
                    </a-col>
                </a-row>

                <FormItemHeading>
                    {{ $t("subscription_plans.payment_gateway_details") }}
                </FormItemHeading>

                <a-row :gutter="16">
                    <a-col :xs="24" :sm="24" :md="12" :lg="12">
                        <a-form-item
                            :label="$t('subscription_plans.stripe_monthly_plan_id')"
                            name="stripe_monthly_plan_id"
                            :help="
                                rules.stripe_monthly_plan_id
                                    ? rules.stripe_monthly_plan_id.message
                                    : null
                            "
                            :validateStatus="
                                rules.stripe_monthly_plan_id ? 'error' : null
                            "
                        >
                            <a-input
                                v-model:value="formData.stripe_monthly_plan_id"
                                :placeholder="
                                    $t('common.placeholder_default_text', [
                                        $t('subscription_plans.stripe_monthly_plan_id'),
                                    ])
                                "
                            />
                        </a-form-item>
                    </a-col>
                    <a-col :xs="24" :sm="24" :md="12" :lg="12">
                        <a-form-item
                            :label="$t('subscription_plans.stripe_annual_plan_id')"
                            name="stripe_annual_plan_id"
                            :help="
                                rules.stripe_annual_plan_id
                                    ? rules.stripe_annual_plan_id.message
                                    : null
                            "
                            :validateStatus="rules.stripe_annual_plan_id ? 'error' : null"
                        >
                            <a-input
                                v-model:value="formData.stripe_annual_plan_id"
                                :placeholder="
                                    $t('common.placeholder_default_text', [
                                        $t('subscription_plans.stripe_annual_plan_id'),
                                    ])
                                "
                                :style="{ width: '100%' }"
                            />
                        </a-form-item>
                    </a-col>
                </a-row>

                <!-- <a-row :gutter="16">
					<a-col :xs="24" :sm="24" :md="12" :lg="12">
						<a-form-item
							:label="$t('subscription_plans.razorpay_monthly_plan_id')"
							name="razorpay_monthly_plan_id"
							:help="
								rules.razorpay_monthly_plan_id
									? rules.razorpay_monthly_plan_id.message
									: null
							"
							:validateStatus="
								rules.razorpay_monthly_plan_id ? 'error' : null
							"
						>
							<a-input
								v-model:value="formData.razorpay_monthly_plan_id"
								:placeholder="
									$t('common.placeholder_default_text', [
										$t('subscription_plans.razorpay_monthly_plan_id'),
									])
								"
							/>
						</a-form-item>
					</a-col>
					<a-col :xs="24" :sm="24" :md="12" :lg="12">
						<a-form-item
							:label="$t('subscription_plans.razorpay_annual_plan_id')"
							name="razorpay_annual_plan_id"
							:help="
								rules.razorpay_annual_plan_id
									? rules.razorpay_annual_plan_id.message
									: null
							"
							:validateStatus="
								rules.razorpay_annual_plan_id ? 'error' : null
							"
						>
							<a-input
								v-model:value="formData.razorpay_annual_plan_id"
								:placeholder="
									$t('common.placeholder_default_text', [
										$t('subscription_plans.razorpay_annual_plan_id'),
									])
								"
								:style="{ width: '100%' }"
							/>
						</a-form-item>
					</a-col>
				</a-row>

				<a-row :gutter="16">
					<a-col :xs="24" :sm="24" :md="12" :lg="12">
						<a-form-item
							:label="$t('subscription_plans.paystack_monthly_plan_id')"
							name="paystack_monthly_plan_id"
							:help="
								rules.paystack_monthly_plan_id
									? rules.paystack_monthly_plan_id.message
									: null
							"
							:validateStatus="
								rules.paystack_monthly_plan_id ? 'error' : null
							"
						>
							<a-input
								v-model:value="formData.paystack_monthly_plan_id"
								:placeholder="
									$t('common.placeholder_default_text', [
										$t('subscription_plans.paystack_monthly_plan_id'),
									])
								"
							/>
						</a-form-item>
					</a-col>
					<a-col :xs="24" :sm="24" :md="12" :lg="12">
						<a-form-item
							:label="$t('subscription_plans.paystack_annual_plan_id')"
							name="paystack_annual_plan_id"
							:help="
								rules.paystack_annual_plan_id
									? rules.paystack_annual_plan_id.message
									: null
							"
							:validateStatus="
								rules.paystack_annual_plan_id ? 'error' : null
							"
						>
							<a-input
								v-model:value="formData.paystack_annual_plan_id"
								:placeholder="
									$t('common.placeholder_default_text', [
										$t('subscription_plans.paystack_annual_plan_id'),
									])
								"
								:style="{ width: '100%' }"
							/>
						</a-form-item>
					</a-col>
				</a-row> -->
            </div>

            <div
                v-if="
                    addEditType == 'add' ||
                    (addEditType == 'edit' && data.default == 'no')
                "
            >
                <FormItemHeading>
                    {{ $t("subscription_plans.features") }}
                </FormItemHeading>

                <a-row :gutter="16">
                    <a-col :xs="24" :sm="24" :md="24" :lg="24">
                        <DynamicFormFeatures
                            :data="formData.features"
                            :addText="$t('website_settings.add_feature')"
                            @onEntry="(allTags) => (formData.features = allTags)"
                        />
                    </a-col>
                </a-row>
            </div>
        </a-form>
        <template #footer>
            <a-space>
                <a-button
                    key="submit"
                    type="primary"
                    :loading="loading"
                    @click="onSubmit"
                >
                    <template #icon>
                        <SaveOutlined />
                    </template>
                    {{ addEditType == "add" ? $t("common.create") : $t("common.update") }}
                </a-button>
                <a-button key="back" @click="onClose">
                    {{ $t("common.cancel") }}
                </a-button>
            </a-space>
        </template>
    </a-drawer>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
import { PlusOutlined, LoadingOutlined, SaveOutlined } from "@ant-design/icons-vue";
import apiAdmin from "../../../../common/composable/apiAdmin";
import common from "../../../../common/composable/common";
import FormItemHeading from "../../../../common/components/common/typography/FormItemHeading.vue";
import DynamicFormFeatures from "../../website-settings/features/DynamicFormFeatures.vue";

export default defineComponent({
    props: [
        "formData",
        "data",
        "visible",
        "url",
        "addEditType",
        "pageTitle",
        "successMessage",
    ],
    components: {
        PlusOutlined,
        LoadingOutlined,
        SaveOutlined,
        FormItemHeading,
        DynamicFormFeatures,
    },
    setup(props, { emit }) {
        const { appSetting } = common();
        const { addEditRequestAdmin, loading, rules } = apiAdmin();

        const onSubmit = () => {
            addEditRequestAdmin({
                url: props.url,
                data: props.formData,
                successMessage: props.successMessage,
                success: (res) => {
                    emit("addEditSuccess", res.xid);
                },
            });
        };

        const onClose = () => {
            rules.value = {};
            emit("closed");
        };

        return {
            appSetting,
            loading,
            rules,
            onClose,
            onSubmit,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "45%",
        };
    },
});
</script>
