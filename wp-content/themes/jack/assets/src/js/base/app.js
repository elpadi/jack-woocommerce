class App {

	constructor() {
		this.modules = {};
		jQuery(document).ready(this.onDocReady.bind(this));
	}

	onDocReady() {
		console.log('App.onDocReady', this.modules, document.body.className);
		document.body.className.split(' ')
			.filter(s => (s in this.modules))
			.forEach(s => this.modules[s].init())
	}

}

const app = new App();
