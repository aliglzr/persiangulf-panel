(()=>{"use strict";function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}function t(t,o,n){return(o=function(t){var o=function(t,o){if("object"!==e(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,o||"default");if("object"!==e(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===o?String:Number)(t)}(t,"string");return"symbol"===e(o)?o:String(o)}(o))in t?Object.defineProperty(t,o,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[o]=n,t}var o,n=(o=function(){document.querySelectorAll('[data-kt-ecommerce-catalog-add-product="product_option"]').forEach((function(e){$(e).hasClass("select2-hidden-accessible")||$(e).select2({minimumResultsForSearch:-1})}))},{init:function(){var e,n,r,a,c,d,i,s,u,l,m,p,_;["#kt_ecommerce_add_product_description","#kt_ecommerce_add_product_meta_description"].forEach((function(e){var t=document.querySelector(e);t&&(t=new Quill(e,{modules:{toolbar:[[{header:[1,2,!1]}],["bold","italic","underline"],["image","code-block"]]},placeholder:"Type your text here...",theme:"snow"}))})),["#kt_ecommerce_add_product_category","#kt_ecommerce_add_product_tags"].forEach((function(e){var t=document.querySelector(e);t&&new Tagify(t,{whitelist:["new","trending","sale","discounted","selling fast","last 10"],dropdown:{maxItems:20,classname:"tagify__inline__suggestions",enabled:0,closeOnSelect:!1}})})),e=document.querySelector("#kt_ecommerce_add_product_discount_slider"),n=document.querySelector("#kt_ecommerce_add_product_discount_label"),noUiSlider.create(e,{start:[10],connect:!0,range:{min:1,max:100}}),e.noUiSlider.on("update",(function(e,t){n.innerHTML=Math.round(e[t]),t&&(n.innerHTML=Math.round(e[t]))})),$("#kt_ecommerce_add_product_options").repeater({initEmpty:!1,defaultValues:{"text-input":"foo"},show:function(){$(this).slideDown(),o()},hide:function(e){$(this).slideUp(e)}}),new Dropzone("#kt_ecommerce_add_product_media",{url:"https://keenthemes.com/scripts/void.php",paramName:"file",maxFiles:10,maxFilesize:10,addRemoveLinks:!0,accept:function(e,t){"wow.jpg"==e.name?t("Naha, you don't."):t()}}),o(),function(){var e=document.getElementById("kt_ecommerce_add_product_status"),t=document.getElementById("kt_ecommerce_add_product_status_select"),o=["bg-success","bg-warning","bg-danger"];$(t).on("change",(function(t){switch(t.target.value){case"published":var n;(n=e.classList).remove.apply(n,o),e.classList.add("bg-success"),a();break;case"scheduled":var c;(c=e.classList).remove.apply(c,o),e.classList.add("bg-warning"),r();break;case"inactive":var d;(d=e.classList).remove.apply(d,o),e.classList.add("bg-danger"),a();break;case"draft":var i;(i=e.classList).remove.apply(i,o),e.classList.add("bg-primary"),a()}}));var n=document.getElementById("kt_ecommerce_add_product_status_datepicker");$("#kt_ecommerce_add_product_status_datepicker").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i"});var r=function(){n.parentNode.classList.remove("d-none")},a=function(){n.parentNode.classList.add("d-none")}}(),r=document.querySelectorAll('[name="method"][type="radio"]'),a=document.querySelector('[data-kt-ecommerce-catalog-add-category="auto-options"]'),r.forEach((function(e){e.addEventListener("change",(function(e){"1"===e.target.value?a.classList.remove("d-none"):a.classList.add("d-none")}))})),c=document.querySelectorAll('input[name="discount_option"]'),d=document.getElementById("kt_ecommerce_add_product_discount_percentage"),i=document.getElementById("kt_ecommerce_add_product_discount_fixed"),c.forEach((function(e){e.addEventListener("change",(function(e){switch(e.target.value){case"2":d.classList.remove("d-none"),i.classList.add("d-none");break;case"3":d.classList.add("d-none"),i.classList.remove("d-none");break;default:d.classList.add("d-none"),i.classList.add("d-none")}}))})),s=document.getElementById("kt_ecommerce_add_product_shipping_checkbox"),u=document.getElementById("kt_ecommerce_add_product_shipping"),s.addEventListener("change",(function(e){e.target.checked?u.classList.remove("d-none"):u.classList.add("d-none")})),p=document.getElementById("kt_ecommerce_add_product_form"),_=document.getElementById("kt_ecommerce_add_product_submit"),m=FormValidation.formValidation(p,{fields:(l={product_name:{validators:{notEmpty:{message:"Product name is required"}}},sku:{validators:{notEmpty:{message:"SKU is required"}}}},t(l,"sku",{validators:{notEmpty:{message:"Product barcode is required"}}}),t(l,"shelf",{validators:{notEmpty:{message:"Shelf quantity is required"}}}),t(l,"price",{validators:{notEmpty:{message:"Product base price is required"}}}),t(l,"tax",{validators:{notEmpty:{message:"Product tax class is required"}}}),l),plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap5({rowSelector:".fv-row",eleInvalidClass:"",eleValidClass:""})}}),_.addEventListener("click",(function(e){e.preventDefault(),m&&m.validate().then((function(e){console.log("validated!"),"Valid"==e?(_.setAttribute("data-kt-indicator","on"),_.disabled=!0,setTimeout((function(){_.removeAttribute("data-kt-indicator"),Swal.fire({text:"Form has been successfully submitted!",icon:"success",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn btn-primary"}}).then((function(e){e.isConfirmed&&(_.disabled=!1,window.location=p.getAttribute("data-kt-redirect"))}))}),2e3)):Swal.fire({html:"Sorry, looks like there are some errors detected, please try again. <br/><br/>Please note that there may be errors in the <strong>General</strong> or <strong>Advanced</strong> tabs",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn btn-primary"}})}))}))}});KTUtil.onDOMContentLoaded((function(){n.init()}))})();