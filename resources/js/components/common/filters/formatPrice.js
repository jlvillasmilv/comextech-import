const setPrice = {};

function formatPrice(value, currency) {
  return new Intl.NumberFormat('es-CL', {
    // style: 'currency',
    currency: currency,
    minimumFractionDigits: currency == 'CLP' ? 0 : 2,
    maximumFractionDigits: currency == 'CLP' ? 0 : 2
  }).format(Number(value));
  // return Number(value).toLocaleString(navigator.language, {
  //   minimumFractionDigits: currency == 'CLP' ? 0 : 2,
  //   maximumFractionDigits: currency == 'CLP' ? 0 : 2
  // });
}

setPrice.install = function(Vue) {
  Vue.filter('setPrice', (val, cur) => {
    return formatPrice(val, cur);
  });
};

export default setPrice;
