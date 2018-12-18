class App {

	constructor() {
		this.modules = {};
	}

	init() {
		jQuery(document).ready(this.onDocReady.bind(this));
	}

	onDocReady() {
		console.log('App.onDocReady', this.modules, document.body.className);
		let classes = document.body.className.split(' ');
		for (let name in this.modules) {
			if (name[0] == '_' || classes.indexOf(name) != -1) {
				this.modules[name].init();
			}
		}
	}

}
