<template>
  <div
    :class="[
      'w-full flex flex-col sm:flex-row flex-wrap justify-center p-4 mt-4 bg-gray-200 rounded-lg shadow-md',
      isTaxDutys ? '' : 'bg-gray-300 opacity-25'
    ]"
  >
    <div
      class="flex flex-col items-center sm:flex-row justify-between sm:w-full xl:w-6/12 px-4 xl:py-0"
    >
      <div class="mobile-sii">
        <figure class="flex justify-center py-4">
          <img
            src="../../../../public/img/SII-white.png"
            class="w-24 mr-1 bg-white px-2 border-2 shadow-md"
            alt="sii"
          />
          <div>
            <p class="text-gray-400"><strong class="text-black">S</strong>ervicio de</p>
            <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>mpuestos</p>
            <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>nternos</p>
          </div>
        </figure>
      </div>
      <div class="py-1 flex flex-col sm:w-6/12">
        <span class="font-semibold">IVA de internacion</span>
        <div class="w-48 flex justify-between bg-gray-300 p-2 rounded">
          <p>19%</p>
          <p>{{ `${$options.filters.setPrice(expenses.iva_amt, 'CLP')} CLP` }}</p>
        </div>
      </div>
      <div class="w-6/12 img-container-sii">
        <figure class="flex justify-evenly">
          <img
            src="../../../../public/img/SII-white.png"
            class="w-24 bg-white px-2 border-2 shadow-md"
            alt="sii"
          />
          <div>
            <p class="text-gray-400"><strong class="text-black">S</strong>ervicio de</p>
            <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>mpuestos</p>
            <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>nternos</p>
          </div>
        </figure>
      </div>
    </div>
    <div
      class="flex flex-col items-center sm:flex-row justify-between sm:w-full xl:w-6/12 sm:px-4 xl:px-2 sm:py-4 xl:py-0"
    >
      <div class="mobile-img-advalorem">
        <figure class="flex justify-center py-4">
          <img
            @click="activeAd()"
            src="../../../../public/img/tgr.png"
            class="sm:mx-4 xl:mx-auto w-24 bg-white mr-1 px-2 border-2 shadow-md focus:outline-none transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 img-advalorem"
            :style="expenses.adv ? { filter: filterImg, opacity: opacityImg } : ''"
            alt="tgr"
          />
          <div>
            <p class="text-gray-400"><strong class="text-black">T</strong>esoreria</p>
            <p class="text-gray-400"><strong class="text-black">G</strong>eneral de la</p>
            <p class="text-gray-400"><strong class="text-black">R</strong>epublica</p>
          </div>
        </figure>
      </div>
      <div class="py-1 flex flex-col sm:w-6/12">
        <span class="font-semibold">Advalorem</span>
        <div class="w-48 flex justify-between bg-gray-300 p-2 rounded">
          <p>6%</p>
          <p>
            {{ expenses.adv ? `${$options.filters.setPrice(expenses.adv_amt, 'CLP')} CLP` : 0 }}
          </p>
        </div>
      </div>
      <div class="w-6/12 img-container-ad">
        <figure class="flex sm:justify-evenly xl:justify-between">
          <img
            @click="activeAd()"
            src="../../../../public/img/tgr.png"
            class="sm:mx-4 xl:mx-auto w-24 bg-white px-2 border-2 shadow-md focus:outline-none transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 img-advalorem"
            :style="expenses.adv ? { filter: filterImg, opacity: opacityImg } : ''"
            alt="tgr"
          />
          <div>
            <p class="text-gray-400"><strong class="text-black">T</strong>esoreria</p>
            <p class="text-gray-400"><strong class="text-black">G</strong>eneral de la</p>
            <p class="text-gray-400"><strong class="text-black">R</strong>epublica</p>
          </div>
        </figure>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import mixinInternment from '../common/mixins/internment/index';
export default {
  data() {
    return {
      filterImg: 'grayscale(0)',
      opacityImg: '1'
    };
  },
  props: {
    amountsDollar: {
      type: Object,
      required: true,
      default: () => {}
    }
  },
  mixins: [mixinInternment],
  computed: {
    ...mapState('internment', ['expenses', 'isTaxDutys'])
  }
};
</script>
