"use strict";function nx_addons_ser_add(e){var t=document.querySelector("#"+e.id);t&&t.parentElement.classList.toggle("active")}function nx_addons_api_show_hde(e){if(e){var t=e.parentElement.querySelector(".api-data-list");if(t){t.classList.toggle("active");var n=e.querySelector("h4.api-head");n&&n.classList.toggle("active")}}}document.querySelector(".nxadd-btn-control-enable").addEventListener("click",function(){for(var e=document.querySelectorAll(".next-addons-event-enable"),t=0;t<e.length;t++)e[t].checked=!0}),document.querySelector(".nxadd-btn-control-disable").addEventListener("click",function(){for(var e=document.querySelectorAll(".next-addons-event-enable"),t=0;t<e.length;t++)e[t].checked=!1});