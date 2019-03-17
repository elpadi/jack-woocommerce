var $ = require('jquery');

class Shop {

	constructor() {
	}

	convertToInsiderCode(node) {
		let ucfirst = s => s[0].toUpperCase() + s.slice(1);
		for (let n of node.childNodes) {
			if (n.nodeType == 3) {
				let i = 'insider code', s = n.textContent;
				for (let w of ['coupon code','coupon']) {
					s = s.replace('A '+w, 'An '+i);
					s = s.replace('a '+w, 'an '+i);
					s = s.replace(ucfirst(w), ucfirst(i));
					s = s.replace(w, i);
				}
				n.textContent = s;
			}
			if (n.nodeType == 1) this.convertToInsiderCode(n);
		}
	}

	onItemAdded(e, fragments, cart_hash) {
		console.log('AddToCart.onItemAdded', e, fragments, cart_hash);
	}

	updateCouponCopy() {
		$('button[name="apply_coupon"]').html('Apply code');
		$('#coupon_code').attr('placeholder', 'Insider code');
		$('.showcoupon')
		.add('.woocommerce-form-coupon p')
			.each((i, el) => this.convertToInsiderCode(el.parentElement));
	}

	init() {
		$(document.body).on('added_to_cart', this.onItemAdded.bind(this));
		this.updateCouponCopy();
	}

}

module.exports = Shop;
