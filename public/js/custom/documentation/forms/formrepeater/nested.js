(()=>{"use strict";var e={init:function(){$("#kt_docs_repeater_nested").repeater({repeaters:[{selector:".inner-repeater",show:function(){$(this).slideDown()},hide:function(e){$(this).slideUp(e)}}],show:function(){$(this).slideDown()},hide:function(e){$(this).slideUp(e)}})}};KTUtil.onDOMContentLoaded((function(){e.init()}))})();