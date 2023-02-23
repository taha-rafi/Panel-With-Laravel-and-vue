import { computed, ref, onMounted } from "vue";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";


const exportData = () => {
    const route = useRoute();
    const store = useStore();
    const { t } = useI18n();

    const exportColumns = ref([]);
    const exportColumnData = ref([]);

    const updatAllExportData = (allExportData) => {
        // store.commit("auth/updatAllExportData", allExportData);
    }

    return {
        exportColumns,
        exportColumnData,
        updatAllExportData,
    };
}

export default exportData;
