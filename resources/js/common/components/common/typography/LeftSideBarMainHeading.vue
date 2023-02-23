<template>
    <li
        v-if="!visible"
        style="
            margin-top: 35px;
            margin-bottom: 17px;
            margin-left: 15px;
            font-size: 14px;
            font-weight: bold;
            color: #838fb9;
        "
    >
        {{ title }}
    </li>
</template>

<script>
export default {
    props: {
        visible: {
            default: true,
        },
        title: {
            default: "",
        },
    },
};
</script>

<style></style>
