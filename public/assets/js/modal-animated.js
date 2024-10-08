/**=====================
    Modal-animated Start
==========================**/
"use strict";
function testAnim(x) {
  $(".modal .modal-dialog").attr("class", "modal-dialog  " + x + "  animated");
}
var modal_animate_custom = {
  init: function () {
    $("#shikoVideo").on("show.bs.modal", function (e) {
      var anim = $("#entrance").val();
      testAnim(anim);
    });
    $("#shikoVideo").on("hide.bs.modal", function (e) {
      var anim = $("#exit").val();
      testAnim(anim);
    });
  },
};
(function ($) {
  "use strict";
  modal_animate_custom.init();
})(jQuery);

/**=====================
  Modal-animated Ends
==========================**/
