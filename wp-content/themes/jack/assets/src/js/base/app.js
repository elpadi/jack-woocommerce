var $ = require('jquery');

class App {

	constructor() {
		this.modules = {};
	}

	init() {
		$(document).ready(this.onDocReady.bind(this));
	}

	onDocReady() {
		console.log('App.onDocReady', this.modules, document.body.className);
		let classes = document.body.className.split(' ');
		for (let name in this.modules) {
			if (name[0] == '_' || classes.indexOf(name) != -1) {
				this.modules[name].init();
			}
		}
		setTimeout(() => document.body.classList.add('doc-ready'), 200);
	}

}

module.exports = App;
