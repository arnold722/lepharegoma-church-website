"use strict";
(self["webpackChunksolace"] = self["webpackChunksolace"] || []).push([["assets_apps_customizer-controls_src_builder_components_SidebarContent_tsx"],{

/***/ "./node_modules/@wordpress/icons/build-module/library/drag-handle.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/drag-handle.js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const dragHandle = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  width: "18",
  height: "18",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 18 18"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M5 4h2V2H5v2zm6-2v2h2V2h-2zm-6 8h2V8H5v2zm6 0h2V8h-2v2zm-6 6h2v-2H5v2zm6 0h2v-2h-2v2z"
}));
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (dragHandle);
//# sourceMappingURL=drag-handle.js.map

/***/ }),

/***/ "./assets/apps/customizer-controls/src/builder/components/SidebarContent.tsx":
/*!***********************************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/builder/components/SidebarContent.tsx ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-sortablejs */ "./node_modules/react-sortablejs/dist/index.js");
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/drag-handle.js");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _BuilderContext__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../BuilderContext */ "./assets/apps/customizer-controls/src/builder/BuilderContext.tsx");








const SidebarContent = ({ items, usedItems }) => {
    const { builder, actions, dragging } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useContext)(_BuilderContext__WEBPACK_IMPORTED_MODULE_6__["default"]);
    // console.log( 'usedItems : ' + JSON.stringify( usedItems, null, 5 ) );
    // 	usedItems : [
    // 		{
    // 			 "id": "button_base"
    // 		},
    // 		{
    // 			 "id": "header_contact"
    // 		},
    // 		{
    // 			 "id": "header_html1"
    // 		},
    // 		{
    // 			 "id": "header_search"
    // 		},
    // 		{
    // 			 "id": "header_social"
    // 		},
    // 		{
    // 			 "id": "logo"
    // 		},
    // 		{
    // 			 "id": "primary-menu"
    // 		}
    //    ]
    const { onDragStart, onDragEnd, setSidebarItems } = actions;
    const allItems = window.SolaceReactCustomize.HFG[builder].items;
    const allItemsArray = Object.values(allItems).map(item => ({ id: item.id }));
    const addItemToSlot = (itemId) => {
        const itemSection = window.SolaceReactCustomize.HFG[builder].items[itemId].section;
        const componentId = window.SolaceReactCustomize.HFG[builder].items[itemId].id;
        // console.log( 'window.SolaceReactCustomize.HFG[builder].items[itemId] : ' + JSON.stringify( window.SolaceReactCustomize.HFG[builder].items[itemId], null, 5 ) );
        // 	window.SolaceReactCustomize.HFG[builder].items[itemId] : {
        // 		"name": "Button Two",
        // 		"description": null,
        // 		"id": "button_base2",
        // 		"width": 2,
        // 		"section": "header_button2",
        // 		"icon": "admin-links",
        // 		"previewImage": null,
        // 		"componentSlug": "hfg-button2",
        // 		"fromTheme": true
        //    }
        const items = document.querySelectorAll(`.solace-builder-sidebar-content .sidebar-items .builder-item[data-id="${componentId}"]`);
        items.forEach(item => item.classList.add('active', 'no-drag'));
        window.wp.customize.section(itemSection).focus();
    };
    const handleChoose = (event) => {
        addItemToSlot(event.item.getAttribute('data-id').toString());
    };
    return (react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", { className: "solace-builder-sidebar-content" },
        react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", { className: "customize-control-title" }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Drag & Drop elements to page', 'solace')),
        allItemsArray && items.length > 0 && (react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", { className: "sidebar-items droppable-wrap" },
            react__WEBPACK_IMPORTED_MODULE_0___default().createElement(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__.ReactSortable
            // Sidebar on click
            // onChoose={handleChoose}
            // Sidebar on drop
            , { 
                // Sidebar on click
                // onChoose={handleChoose}
                // Sidebar on drop
                onSort: handleChoose, onEnd: onDragEnd, animation: 0, filter: ".no-drag", group: builder, className: `droppable`, disabled: dragging, onStart: onDragStart, list: allItemsArray, setList: (next) => {
                    const nextState = next
                        .map((item) => {
                        return { id: item.id };
                    })
                        .sort((a, b) => {
                        return a.id < b.id ? -1 : 1;
                    });
                    setSidebarItems(nextState);
                } }, allItemsArray.map((item) => {
                const { name } = allItems[item.id];
                const isUsed = usedItems.some((usedItem) => usedItem.id === item.id);
                return (react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", { className: `builder-item ${isUsed ? 'active no-drag' : ''}`, key: item.id },
                    react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Icon, { className: "handle", icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_7__["default"], size: 15 }),
                    react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", null, name),
                    react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_3__.SVG, { width: "15", height: "15", viewBox: "0 0 15 15", fill: "none", xmlns: "http://www.w3.org/2000/svg" },
                        react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_3__.Path, { d: "M12.6024 6.83408L11.8344 6.06108C11.7668 5.99835 11.7125 5.92265 11.6749 5.83848C11.6372 5.75432 11.6169 5.66343 11.6152 5.57125C11.6135 5.47906 11.6303 5.38748 11.6648 5.30196C11.6993 5.21644 11.7506 5.13874 11.8158 5.07351C11.8809 5.00828 11.9586 4.95686 12.044 4.92231C12.1295 4.88776 12.2211 4.8708 12.3133 4.87244C12.4055 4.87408 12.4964 4.89429 12.5806 4.93186C12.6648 4.96942 12.7406 5.02358 12.8034 5.09108L14.7424 7.03108C14.8706 7.15969 14.9427 7.33393 14.9427 7.51558C14.9427 7.69724 14.8706 7.87148 14.7424 8.00008L12.8034 9.93908C12.7397 10.0027 12.6642 10.0532 12.5811 10.0876C12.4979 10.122 12.4088 10.1398 12.3189 10.1398C12.2289 10.1398 12.1398 10.122 12.0566 10.0876C11.9735 10.0532 11.898 10.0027 11.8344 9.93908C11.7707 9.87546 11.7203 9.79992 11.6858 9.71679C11.6514 9.63366 11.6337 9.54456 11.6337 9.45458C11.6337 9.3646 11.6514 9.27551 11.6858 9.19238C11.7203 9.10924 11.7707 9.03371 11.8344 8.97008L12.6024 8.20208H8.15635V12.6511L8.92435 11.8831C8.98798 11.8195 9.06351 11.769 9.14664 11.7346C9.22977 11.7001 9.31887 11.6824 9.40885 11.6824C9.49883 11.6824 9.58793 11.7001 9.67106 11.7346C9.75419 11.769 9.82973 11.8195 9.89335 11.8831C9.95698 11.9467 10.0074 12.0222 10.0419 12.1054C10.0763 12.1885 10.094 12.2776 10.094 12.3676C10.094 12.4576 10.0763 12.5467 10.0419 12.6298C10.0074 12.7129 9.95698 12.7885 9.89335 12.8521L7.95535 14.7921C7.82675 14.9204 7.65251 14.9924 7.47085 14.9924C7.28919 14.9924 7.11495 14.9204 6.98635 14.7921L5.04635 12.8521C4.98273 12.7885 4.93225 12.7129 4.89782 12.6298C4.86339 12.5467 4.84566 12.4576 4.84566 12.3676C4.84566 12.2776 4.86339 12.1885 4.89782 12.1054C4.93225 12.0222 4.98272 11.9467 5.04635 11.8831C5.10998 11.8195 5.18551 11.769 5.26864 11.7346C5.35177 11.7001 5.44087 11.6824 5.53085 11.6824C5.62083 11.6824 5.70993 11.7001 5.79306 11.7346C5.87619 11.769 5.95173 11.8195 6.01535 11.8831L6.78435 12.6511V8.20508H2.33935L3.10835 8.97308C3.23685 9.10158 3.30904 9.27586 3.30904 9.45758C3.30904 9.63931 3.23685 9.81359 3.10835 9.94208C2.97985 10.0706 2.80557 10.1428 2.62385 10.1428C2.44213 10.1428 2.26785 10.0706 2.13935 9.94208L0.20035 8.00408C0.0720517 7.87548 0 7.70124 0 7.51958C0 7.33793 0.0720517 7.16369 0.20035 7.03508L2.14035 5.09508C2.20315 5.02758 2.27891 4.97342 2.36312 4.93586C2.44732 4.89829 2.53823 4.87808 2.63041 4.87644C2.7226 4.8748 2.81417 4.89176 2.89965 4.92631C2.98514 4.96086 3.06278 5.01228 3.12794 5.07751C3.19311 5.14274 3.24445 5.22044 3.27891 5.30595C3.31337 5.39147 3.33023 5.48306 3.3285 5.57525C3.32676 5.66743 3.30646 5.75832 3.26881 5.84248C3.23115 5.92665 3.17692 6.00235 3.10935 6.06508L2.34035 6.83308H6.78635V2.38908L6.01635 3.16108C5.95272 3.22471 5.87719 3.27518 5.79406 3.30961C5.71093 3.34405 5.62183 3.36177 5.53185 3.36177C5.44187 3.36177 5.35277 3.34405 5.26964 3.30961C5.18651 3.27518 5.11098 3.22471 5.04735 3.16108C4.98373 3.09746 4.93325 3.02192 4.89882 2.93879C4.86439 2.85566 4.84666 2.76656 4.84666 2.67658C4.84666 2.5866 4.86439 2.49751 4.89882 2.41438C4.93325 2.33124 4.98373 2.25571 5.04735 2.19208L6.98735 0.253085C7.11595 0.124786 7.29019 0.0527344 7.47185 0.0527344C7.65351 0.0527344 7.82775 0.124786 7.95635 0.253085L9.89535 2.19308C9.96428 2.25532 10.0198 2.33092 10.0586 2.41529C10.0975 2.49966 10.1187 2.59104 10.1211 2.68388C10.1235 2.77671 10.107 2.86907 10.0726 2.95533C10.0382 3.04159 9.98658 3.11995 9.92094 3.18565C9.85531 3.25135 9.777 3.30302 9.69078 3.33752C9.60455 3.37202 9.51222 3.38862 9.41938 3.38632C9.32654 3.38403 9.23513 3.36287 9.15072 3.32415C9.06631 3.28543 8.99065 3.22995 8.92835 3.16108L8.16035 2.39308V6.83408H12.6063H12.6024Z", fill: "white" }))));
            })))),
        !items.length && (react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", { className: "no-components" },
            react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('All available components are used inside the builder', 'solace'))))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SidebarContent);


/***/ })

}]);
//# sourceMappingURL=1d5f9b8bdb24de0196b8.js.map