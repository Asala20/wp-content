/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/Search.js"
/*!*******************************!*\
  !*** ./src/modules/Search.js ***!
  \*******************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

class Search {
  //1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML();
    this.openButton = jquery__WEBPACK_IMPORTED_MODULE_0___default()(".js-search-trigger");
    this.closeButton = jquery__WEBPACK_IMPORTED_MODULE_0___default()(".search-overlay__close");
    this.searchOverlay = jquery__WEBPACK_IMPORTED_MODULE_0___default()(".search-overlay");
    this.searchField = jquery__WEBPACK_IMPORTED_MODULE_0___default()("#search-term");
    this.resultsDiv = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#search-overlay__results');
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  //2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  //3. methods (functions, action...)
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);
      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader" ></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchField.val();
  }
  getResults() {
    let searchTerm = this.searchField.val();
    jquery__WEBPACK_IMPORTED_MODULE_0___default().when(jquery__WEBPACK_IMPORTED_MODULE_0___default().getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + searchTerm), jquery__WEBPACK_IMPORTED_MODULE_0___default().getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + searchTerm), jquery__WEBPACK_IMPORTED_MODULE_0___default().getJSON(universityData.root_url + '/wp-json/wp/v2/project?search=' + searchTerm), jquery__WEBPACK_IMPORTED_MODULE_0___default().getJSON(universityData.root_url + '/wp-json/wp/v2/event?search=' + searchTerm), jquery__WEBPACK_IMPORTED_MODULE_0___default().getJSON(universityData.root_url + '/wp-json/wp/v2/professor?search=' + searchTerm)).then((posts, pages, projects, events, professors) => {
      this.resultsDiv.html(`
                <div class="search-results-layout">
                    
                    <!-- COLUMN 1: General Info -->
                    <div class="search-col">
                        <h2 class="search-overlay__section-title">General Info</h2>
                        ${posts[0].length || pages[0].length ? '<ul class="search-list">' : '<p>No general information found.</p>'}
                            ${pages[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                            ${posts[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${posts[0].length || pages[0].length ? '</ul>' : ''}
                    </div>

                    <!-- COLUMN 2: Projects & Professors -->
                    <div class="search-col">
                        <h2 class="search-overlay__section-title">Projects</h2>
                        ${projects[0].length ? '<ul class="search-list">' : '<p>No projects found.</p>'}
                            ${projects[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${projects[0].length ? '</ul>' : ''}

                        <h2 class="search-overlay__section-title" style="margin-top: 30px;">Professors</h2>
                        ${professors[0].length ? '<ul class="search-list">' : '<p>No professors found.</p>'}
                            ${professors[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${professors[0].length ? '</ul>' : ''}
                    </div>

                    <!-- COLUMN 3: Events -->
                    <div class="search-col">
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${events[0].length ? '<ul class="search-list">' : '<p>No events found.</p>'}
                            ${events[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${events[0].length ? '</ul>' : ''}
                    </div>

                </div>
            `);
      this.isSpinnerVisible = false;
    }, () => {
      this.resultsDiv.html('<p>Unexpected error, please try again.</p>');
      this.isSpinnerVisible = false;
    });
  }
  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen && !jquery__WEBPACK_IMPORTED_MODULE_0___default()("input, textarea").is(':focus')) {
      this.openOverlay();
    }
    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    jquery__WEBPACK_IMPORTED_MODULE_0___default()("body").addClass("body-no-scroll");
    this.searchField.val('');
    setTimeout(() => this.searchField.focus(), 301);
    this.isOverlayOpen = true;
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    jquery__WEBPACK_IMPORTED_MODULE_0___default()("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }
  addSearchHTML() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()("body").append(`
                <div class="search-overlay">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" name="" id="search-term">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                    <div id="search-overlay__results"></div>
                </div>
            `);
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Search);

/***/ },

/***/ "jquery"
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
(module) {

module.exports = window["jQuery"];

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Check if module exists (development only)
/******/ 		if (__webpack_modules__[moduleId] === undefined) {
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_Search__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/Search */ "./src/modules/Search.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);



// Wrap in $(document).ready
jquery__WEBPACK_IMPORTED_MODULE_1___default()(document).ready(function () {
  const search = new _modules_Search__WEBPACK_IMPORTED_MODULE_0__["default"]();
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map