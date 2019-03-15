var $ = require('jquery');

class Shop {

	constructor() {
	}

	onItemAdded(e, fragments, cart_hash) {
		console.log('AddToCart.onItemAdded', e, fragments, cart_hash);
	}

	init() {
		$(document.body).on('added_to_cart', this.onItemAdded.bind(this));
	}

}

module.exports = Shop;
