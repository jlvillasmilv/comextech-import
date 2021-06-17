<template>
    <Container :bg="false">
        <Form  @Add="AddPay" />
        <Table :data="pays" />
    </Container>
</template>

<script>
import Container from "../components/Container.vue";
import Form from "../components/PaymentProvider/Form.vue";
import Table from "../components/PaymentProvider/Table.vue";

export default {
    components: { Table, Form, Container },
    data() {
        return {
            creating: false,
            pays: []
        };
    },
    methods: {
        AddPay(payload) {
            this.pays.push({
                    percentage: "Majuriic" + this.pays.length ,
                    datePay: "Majuriic",
                    typePay: "Majuriic"
                })
            console.log(payload);
        }
    }
};
</script>

<style></style>
