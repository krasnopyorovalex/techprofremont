jQuery(function() {

    var checkboxList = jQuery(".checkbox_list");
    if(checkboxList.length) {
        checkboxList.on("change", "input[type=checkbox]", function () {
            var _this = jQuery(this),
                prop = _this.prop("checked"),
                key = _this.closest(".tab").attr("data-key");

            return jQuery(".category_" + key + " input[type=checkbox]").prop("checked", prop);
        });
        checkboxList.on("change", ".tab_t input[type=checkbox]", function () {
            var _this = jQuery(this),
                key = _this.closest(".tab_t").prevAll(".tab:first").attr("data-key");

            return jQuery("div[data-key="+key+"] input[type=checkbox]").prop("checked", true);
        });
    }
});
