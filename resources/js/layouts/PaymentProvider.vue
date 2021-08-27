<template>
    <Container :bg="false">
        <Form @Add="AddPay" :amountTotal="amountTotal" />
        <Table :data="pays" />
    </Container>
</template>

<script>
import Container from "../components/Container.vue";
import Form from "../components/PaymentProvider/Form.vue";
 
export default {
    components: { Table, Form, Container },
    props: {
        amountTotal: {
            required: true,
            default: 0
        }
    },
    data() {
        return {
            creating: false,
            pays: []
        };
    },
    methods: {
        AddPay(payload) {
            this.pays.push({ ...payload });
        }
    },
    computed: {}
};
</script>

<style></style>
