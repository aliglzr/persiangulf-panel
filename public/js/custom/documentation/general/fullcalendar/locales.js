(()=>{"use strict";var t={init:function(){var t,e,n;t=document.getElementById("kt_docs_fullcalendar_locale_selector"),e=document.getElementById("kt_docs_fullcalendar_locales"),(n=new FullCalendar.Calendar(e,{headerToolbar:{left:"prev,next today",center:"title",right:"dayGridMonth,timeGridWeek,timeGridDay,listMonth"},initialDate:"2020-09-12",locale:"en",buttonIcons:!1,weekNumbers:!0,navLinks:!0,editable:!0,dayMaxEvents:!0,events:[{title:"All Day Event",start:"2020-09-01"},{title:"Long Event",start:"2020-09-07",end:"2020-09-10"},{groupId:999,title:"Repeating Event",start:"2020-09-09T16:00:00"},{groupId:999,title:"Repeating Event",start:"2020-09-16T16:00:00"},{title:"Conference",start:"2020-09-11",end:"2020-09-13"},{title:"Meeting",start:"2020-09-12T10:30:00",end:"2020-09-12T12:30:00"},{title:"Lunch",start:"2020-09-12T12:00:00"},{title:"Meeting",start:"2020-09-12T14:30:00"},{title:"Happy Hour",start:"2020-09-12T17:30:00"},{title:"Dinner",start:"2020-09-12T20:00:00"},{title:"Birthday Party",start:"2020-09-13T07:00:00"},{title:"Click for Google",url:"http://google.com/",start:"2020-09-28"}]})).render(),n.getAvailableLocaleCodes().forEach((function(e){var n=document.createElement("option");n.value=e,n.selected="en"==e,n.innerText=e,t.appendChild(n)})),$(t).on("change",(function(){this.value&&n.setOption("locale",this.value)})),n.render()}};KTUtil.onDOMContentLoaded((function(){t.init()}))})();