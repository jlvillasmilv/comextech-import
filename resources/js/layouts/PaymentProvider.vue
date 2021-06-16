<template>
        <Container :bg="false">
                <Form />
                <Table/>
        </Container>
       
</template>

<script>
import Container from '../components/Container.vue';
import Form from "../components/PaymentProvider/Form.vue";
import Table from "../components/PaymentProvider/Table.vue";

export default {
    components: { Table, Form, Container },
    data() {
        return {
            creating: false
        };
    }
};
</script>

<style></style>
