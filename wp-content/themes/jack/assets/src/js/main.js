const App = require('./base/app');
const ExternalLinks = require('./base/external-links');
const Menu = require('./base/menu');
const Shop = require('./base/shop');

const SingleProduct = require('./content/single-product');

const app = new App();

app.modules['_external-links'] = new ExternalLinks();
app.modules['_menu'] = new Menu();
app.modules['_shop'] = new Shop();
app.modules['single-product'] = new SingleProduct();

app.init();
