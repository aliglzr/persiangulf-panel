(()=>{"use strict";var e,t,r,o,a,s=(a=function(){return 100===o.getScore()},{init:function(){e=document.querySelector("#kt_new_password_form"),t=document.querySelector("#kt_new_password_submit"),o=KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')),r=FormValidation.formValidation(e,{fields:{password:{validators:{notEmpty:{message:"The password is required"},callback:{message:"Please enter valid password",callback:function(e){if(e.value.length>0)return a()}}}},"confirm-password":{validators:{notEmpty:{message:"The password confirmation is required"},identical:{compare:function(){return e.querySelector('[name="password"]').value},message:"The password and its confirm are not the same"}}},toc:{validators:{notEmpty:{message:"You must accept the terms and conditions"}}}},plugins:{trigger:new FormValidation.plugins.Trigger({event:{password:!1}}),bootstrap:new FormValidation.plugins.Bootstrap5({rowSelector:".fv-row",eleInvalidClass:"",eleValidClass:""})}}),t.addEventListener("click",(function(a){a.preventDefault(),r.revalidateField("password"),r.validate().then((function(r){"Valid"==r?(t.setAttribute("data-kt-indicator","on"),t.disabled=!0,setTimeout((function(){t.removeAttribute("data-kt-indicator"),t.disabled=!1,Swal.fire({text:"You have successfully reset your password!",icon:"success",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn btn-primary"}}).then((function(t){if(t.isConfirmed){e.querySelector('[name="password"]').value="",e.querySelector('[name="confirm-password"]').value="",o.reset();var r=e.getAttribute("data-kt-redirect-url");r&&(location.href=r)}}))}),1500)):Swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn btn-primary"}})}))})),e.querySelector('input[name="password"]').addEventListener("input",(function(){this.value.length>0&&r.updateFieldStatus("password","NotValidated")}))}});KTUtil.onDOMContentLoaded((function(){s.init()}))})();