"use strict";function nx_image_popup(){event.preventDefault();var e=document.getElementsByTagName("html")[0];if(!e)return!1;e.setAttribute("style","margin-right: 17px; overflow: hidden;");var t=document.getElementsByTagName("body")[0];if(!t)return!1;t.classList.add("nx-pop-body");var n,p=this.innerHTML,i=this.getAttribute("nx-pop-slide"),o=this.getAttribute("data-text");if(o||(o=""),(n=t.querySelector(".nx-popup-hidden-bg"))?n.classList.toggle("nx-bg-ready"):((n=document.createElement("div")).setAttribute("class","nx-popup-hidden-bg nx-bg-ready"),t.appendChild(n)),!(u=t.querySelector(".nx-popup-hidden"))){var r=document.createElement("div");r.setAttribute("class","nx-popup-hidden nx-popup-active"),t.appendChild(r);var u=t.querySelector(".nx-popup-hidden")}if(u.classList.add("nx-popup-active"),u.innerHTML="",null!=i&&"yes"==i||u.addEventListener("click",nx_image_popup_close),!u.querySelector(".nx-popup-close-button")){var a=document.createElement("button");a.setAttribute("class","nx-popup-close-button"),a.setAttribute("onclick","nx_image_popup_close()"),a.innerHTML="X",u.appendChild(a)}u.innerHTML+=p;var d=document.createElement("p");d.setAttribute("class","nx-image-popup-text"),d.innerHTML=o,u.appendChild(d)}function nx_image_popup_close(){var e=document.getElementsByTagName("html")[0];if(!e)return!1;var t=document.getElementsByTagName("body")[0];if(!t)return!1;t.classList.add("nx-popup-hide");var n=t.querySelector(".nx-popup-hidden"),p=t.querySelector(".nx-popup-hidden-bg");setTimeout(function(){e.setAttribute("style",""),t.classList.remove("nx-pop-body"),t.classList.remove("nx-popup-hide"),n&&(n.classList.toggle("nx-popup-active"),n.innerHTML="",t.removeChild(n)),p&&t.removeChild(p)},500)}function nx_popup_image(e){var t=document.querySelectorAll(e);if(t)for(var n=0;n<t.length;n++)t[n].addEventListener("click",nx_image_popup)}