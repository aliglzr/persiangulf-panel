(()=>{"use strict";var e,t,n,s,a,c,r,o,d,l,i,m,u,L,h,k=(L=function(e){setTimeout((function(){var s=KTUtil.getRandomInt(1,3);t.classList.add("d-none"),3===s?(n.classList.add("d-none"),a.classList.remove("d-none")):(n.classList.remove("d-none"),a.classList.add("d-none")),e.complete()}),1500)},h=function(e){t.classList.remove("d-none"),n.classList.add("d-none"),a.classList.add("d-none")},{init:function(){(e=document.querySelector("#kt_docs_search_handler_menu"))&&(s=e.querySelector('[data-kt-search-element="wrapper"]'),e.querySelector('[data-kt-search-element="form"]'),t=e.querySelector('[data-kt-search-element="main"]'),n=e.querySelector('[data-kt-search-element="results"]'),a=e.querySelector('[data-kt-search-element="empty"]'),c=e.querySelector('[data-kt-search-element="preferences"]'),r=e.querySelector('[data-kt-search-element="preferences-show"]'),o=e.querySelector('[data-kt-search-element="preferences-dismiss"]'),d=e.querySelector('[data-kt-search-element="advanced-options-form"]'),l=e.querySelector('[data-kt-search-element="advanced-options-form-show"]'),i=e.querySelector('[data-kt-search-element="advanced-options-form-cancel"]'),m=e.querySelector('[data-kt-search-element="advanced-options-form-search"]'),(u=new KTSearch(e)).on("kt.search.process",L),u.on("kt.search.clear",h),r.addEventListener("click",(function(){s.classList.add("d-none"),c.classList.remove("d-none")})),o.addEventListener("click",(function(){s.classList.remove("d-none"),c.classList.add("d-none")})),l.addEventListener("click",(function(){s.classList.add("d-none"),d.classList.remove("d-none")})),i.addEventListener("click",(function(){s.classList.remove("d-none"),d.classList.add("d-none")})),m.addEventListener("click",(function(){})))}});KTUtil.onDOMContentLoaded((function(){k.init()}))})();