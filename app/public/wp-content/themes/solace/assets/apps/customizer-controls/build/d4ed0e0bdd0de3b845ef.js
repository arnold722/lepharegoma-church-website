"use strict";
(self["webpackChunksolace"] = self["webpackChunksolace"] || []).push([["assets_apps_customizer-controls_src_repeater_IconsContent_js"],{

/***/ "./assets/apps/customizer-controls/src/repeater/IconsContent.js":
/*!**********************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/repeater/IconsContent.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_3__);





const IconsContent = ({
  onIconChoice,
  setVisible,
  icons
}) => {
  const [searchValue, setSearchValue] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const transformIcons = tempIcons => {
    return Object.entries(tempIcons).map(([iconName, iconSVG]) => {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Tooltip, {
        className: "tooltip",
        text: iconName,
        key: iconName
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
        className: "icon-button",
        onClick: () => {
          onIconChoice(iconName);
          setVisible(false);
          setSearchValue('');
        }
      }, iconSVG));
    });
  };
  const filterOptions = () => {
    const tempIcons = {};
    for (const [iconName, svg] of Object.entries(icons)) {
      if (iconName.indexOf(searchValue) > -1) {
        tempIcons[iconName] = svg;
      }
    }
    return tempIcons;
  };
  const iconsToShow = transformIcons(filterOptions());
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "icons-popover-content"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextControl, {
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Search', 'solace'),
    value: searchValue,
    type: "search",
    onChange: setSearchValue,
    className: "icons-popover-header"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "icons-container"
  }, iconsToShow));
};
IconsContent.propTypes = {
  onIconChoice: (prop_types__WEBPACK_IMPORTED_MODULE_3___default().func).isRequired,
  setVisible: (prop_types__WEBPACK_IMPORTED_MODULE_3___default().func).isRequired,
  icons: (prop_types__WEBPACK_IMPORTED_MODULE_3___default().object).isRequired
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (IconsContent);

/***/ })

}]);
//# sourceMappingURL=d4ed0e0bdd0de3b845ef.js.map