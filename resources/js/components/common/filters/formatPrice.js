const setPrice = {};

function formatPrice(value, currency) {
  return Number(value).toLocaleString(navigator.language, {
    minimumFractionDigits: currency == 'CLP' ? 0 : 2,
    maximumFractionDigits: currency == 'CLP' ? 0 : 2
  });
}

setPrice.install = function(Vue) {
  Vue.filter('setPrice', (val, cur) => {
    return formatPrice(val, cur);
  });
};

export default setPrice;
