const path = require('path');

module.exports = {
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.resolve('resources/js'),
            '$comp': path.join(__dirname, './resources/js/components')
        },
    },
};
