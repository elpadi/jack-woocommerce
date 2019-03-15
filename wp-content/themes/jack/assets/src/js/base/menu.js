var $ = require('jquery');

class Menu {

	constructor() {
	}

	clone() {
		this.menu = document.getElementById('menu-header-main');
		this.desktop = this.menu.cloneNode(true);
		this.desktop.id = 'desktop-' + this.desktop.id;
		for (let n of this.desktop.querySelectorAll('[id]')) n.id = 'desktop-' + n.id;
		this.menu.insertAdjacentElement('afterend', this.desktop);
	}

	drawBurger() {
		this.canvas.width = this.canvas.width;
		let ctx = this.canvas.getContext('2d');
		ctx.fillRect(4, 6, 24, 4);
		ctx.fillRect(4, 14, 24, 4);
		ctx.fillRect(4, 22, 24, 4);
	}

	drawX() {
		this.canvas.width = this.canvas.width;
		let ctx = this.canvas.getContext('2d');
		ctx.lineWidth = 4;
		ctx.beginPath();
		ctx.moveTo(4, 6);
		ctx.lineTo(28, 26);
		ctx.moveTo(28, 6);
		ctx.lineTo(4, 26);
		ctx.stroke();
	}

	createBurgerIcon() {
		this.canvas = document.createElement('canvas');
		this.canvas.width = 32; this.canvas.height = 32;
		this.drawBurger();
		return this.canvas;
	}

	addBurger() {
		this.social = document.getElementById('menu-social-menu');
		let li = this.social.children[this.social.children.length - 1].cloneNode(false);
		li.id = 'menu-item-burger';
		li.appendChild(this.createBurgerIcon());
		this.social.appendChild(li);
		li.addEventListener('click', e => {
			document.body.classList.contains('menu-visible') ? this.drawBurger() : this.drawX();
			document.body.classList.toggle('menu-visible');
		});
	}

	shortenMobile() {
		for (let n of this.menu.querySelectorAll('a'))
			n.innerHTML = n.innerHTML.replace('Volume ', 'Vol.').replace('Issue ', '#');
	}

	init() {
		this.clone();
		this.shortenMobile();
		this.addBurger();
		$('.submenu-expand').removeClass('submenu-expand');
	}

}

module.exports = Menu;
