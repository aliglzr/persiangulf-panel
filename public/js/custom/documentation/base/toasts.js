(()=>{"use strict";var t={init:function(){var t,e,n;t=document.getElementById("kt_docs_toast_toggle_button"),e=document.getElementById("kt_docs_toast_toggle"),n=bootstrap.Toast.getOrCreateInstance(e),t.addEventListener("click",(function(t){t.preventDefault(),n.show()})),function(){var t=document.getElementById("kt_docs_toast_stack_button"),e=document.getElementById("kt_docs_toast_stack_container"),n=document.querySelector('[data-kt-docs-toast="stack"]');n.parentNode.removeChild(n),t.addEventListener("click",(function(t){t.preventDefault();var o=n.cloneNode(!0);e.append(o),bootstrap.Toast.getOrCreateInstance(o).show()}))}()}};KTUtil.onDOMContentLoaded((function(){t.init()}))})();