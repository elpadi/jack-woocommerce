class ExternalLinks {

	constructor() {
	}

	getLinks() {
		return document.querySelectorAll('#menu-social-menu a');
	}

	init() {
		for (let l of this.getLinks()) l.target = '_blank';
	}

}
