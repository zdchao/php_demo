var Page = function(total,pagecount) {
	this.total = total;
	this.pagecount = pagecount;
	this.getPagecount = function(page) {
		this.page = page;
		var pages = {};
		if (this.total <= this.pagecount) {
			return;
		}
		var count = this.total / this.pagecount;
		var floor = Math.floor(count);
		if (count > floor) {
			count = floor ;
		}
		if (count >=1 && this.page != 0) {
			pages.首页 = 0;
		}
		if (this.page > 0) {
			pages.上一页 = this.page-1;
		}
		if (count > this.page) {
			pages.下一页 = this.page+1; 
		}
		if (count > this.page) {
			pages.尾页 = count;
		}
		return pages;
	}
	
}