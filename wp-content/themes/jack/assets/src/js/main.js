const app = new App();

app.modules['_external-links'] = new ExternalLinks();
app.modules['_menu'] = new Menu();
app.modules['single-product'] = new SingleProduct();

app.init();
