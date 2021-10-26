<template>
    <div class="row d-flex justify-content-around">
        <div class="col-lg-6">
            <FormPersonal :client="data"></FormPersonal>
        </div>
        <div class="col-lg-6">
            <FormCompany :company="data.company"></FormCompany>
        </div>
    </div>
</template>

<script>
import FormPersonal from "../components/FormPersonal";
import FormCompany from "../components/FormCompany";

export default {
    data() {
        return {
            client: false,
            data: {},
            user: false
        };
    },
    components: {
        FormPersonal: FormPersonal,
        FormCompany: FormCompany
    },
    methods: {
        async getProfileClient() {
            let response = await axios.get("/clients/" + this.user.id);
            this.data = response.data;
        }
    },
    created() {
        this.user = JSON.parse(
            document.head.querySelector('meta[name="user"]').content
        );
        this.getProfileClient();
    }
};
</script>
