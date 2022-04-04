<template>
  <tabs :options="{ useUrlFragment: false }">
    <tab name="Facturas(SII)">
      <div class="flex justify-around">
        <invoceStore></invoceStore>
      </div>
    </tab>
    <tab name="Subir factura (XML)">
      <div>
        <form_xml></form_xml>
      </div>
    </tab>
  </tabs>
</template>

<script>
import Invoice from '../components/Factoring/Invoices';
import FormXml from '../components/Factoring/FormXml';

export default {
  name: 'Quote',
  data: function () {
    return {
      data: {},
    };
  },
  components: {
    invoceStore: Invoice,
    form_xml: FormXml,
  }
 
};
</script>
