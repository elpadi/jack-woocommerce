class SingleProduct {

	constructor() {
	}

	init() {
		console.log('SingleProduct.init');
		this.images = jQuery('.cover-images img');
		this.select = jQuery('#pa_cover');
		if (this.images.length && this.select.length) {
			this.images.on('click', e => this.change(this.images.index(e.target)));
			this.change(0);
		}
	}

	change(i) {
		this.images.removeClass('selected');
		this.images.eq(i).addClass('selected');
		let opt = this.select.children().eq(i + 1).val();
		this.select.val(opt).trigger('change');
		console.log('SingleProduct.change', i, opt);
	}

}
