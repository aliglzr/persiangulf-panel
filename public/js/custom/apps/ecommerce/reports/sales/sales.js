(()=>{"use strict";var t,e,n={init:function(){(t=document.querySelector("#kt_ecommerce_report_sales_table"))&&(t.querySelectorAll("tbody tr").forEach((function(t){var e=t.querySelectorAll("td"),n=moment(e[0].innerHTML,"MMM DD, YYYY").format();e[0].setAttribute("data-order",n)})),e=$(t).DataTable({info:!1,order:[],pageLength:10}),function(){var t=moment().subtract(29,"days"),e=moment(),n=$("#kt_ecommerce_report_sales_daterangepicker");function o(t,e){n.html(t.format("MMMM D, YYYY")+" - "+e.format("MMMM D, YYYY"))}n.daterangepicker({startDate:t,endDate:e,ranges:{Today:[moment(),moment()],Yesterday:[moment().subtract(1,"days"),moment().subtract(1,"days")],"Last 7 Days":[moment().subtract(6,"days"),moment()],"Last 30 Days":[moment().subtract(29,"days"),moment()],"This Month":[moment().startOf("month"),moment().endOf("month")],"Last Month":[moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]}},o),o(t,e)}(),function(){var e="Sales Report",n=(new $.fn.dataTable.Buttons(t,{buttons:[{extend:"copyHtml5",title:e},{extend:"excelHtml5",title:e},{extend:"csvHtml5",title:e},{extend:"pdfHtml5",title:e}]}).container().appendTo($("#kt_ecommerce_report_sales_export")),document.querySelectorAll("#kt_ecommerce_report_sales_export_menu [data-kt-ecommerce-export]"));n.forEach((function(t){t.addEventListener("click",(function(t){t.preventDefault();var e=t.target.getAttribute("data-kt-ecommerce-export");document.querySelector(".dt-buttons .buttons-"+e).click()}))}))}(),document.querySelector('[data-kt-ecommerce-order-filter="search"]').addEventListener("keyup",(function(t){e.search(t.target.value).draw()})))}};KTUtil.onDOMContentLoaded((function(){n.init()}))})();