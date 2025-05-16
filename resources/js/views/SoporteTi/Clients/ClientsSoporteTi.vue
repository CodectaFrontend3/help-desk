<script>
import tableComponent from "@/components/Commons/TableComponent.vue";
import apiServices from "../../../services/ApiServices";

export default {
    name: "ClientsSoporteTi",
    components: { tableComponent },
    data() {
        return {

        };
    },


};
</script>

<template>
    <div class="content-area">
        <router-view />
    </div>
</template>

<style scoped></style>
