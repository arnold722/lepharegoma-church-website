"use strict";
(self["webpackChunksolace"] = self["webpackChunksolace"] || []).push([["assets_apps_customizer-controls_src_font-family_FontFamilySelector_js"],{

/***/ "./assets/apps/customizer-controls/src/font-family/FontFamilySelector.js":
/*!*******************************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/font-family/FontFamilySelector.js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _FontPreviewLink_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FontPreviewLink.js */ "./assets/apps/customizer-controls/src/font-family/FontPreviewLink.js");
/* harmony import */ var react_visibility_sensor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-visibility-sensor */ "./node_modules/react-visibility-sensor/dist/visibility-sensor.js");
/* harmony import */ var react_visibility_sensor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_visibility_sensor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/update.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/close.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);








const FontFamilySelector = ({
  fonts,
  selected,
  onFontChoice,
  inheritDefault,
  maybeGetTypekit,
  systemFonts
}) => {
  const [visible, setVisible] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [search, setSearch] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const [loadUntil, setLoadUntil] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(20);
  const getFonts = () => {
    const result = {};
    if (!search) {
      return fonts;
    }
    Object.keys(fonts).map(key => {
      result[key] = fonts[key].filter(value => {
        return value.toLowerCase().includes(search.toLowerCase());
      });
      return key;
    });
    return result;
  };
  const getFontList = () => {
    const groups = getFonts();
    const options = [];
    if (!systemFonts) {
      options.push((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
        key: "default",
        className: 'default-value ' + !selected ? 'selected' : 0
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_FontPreviewLink_js__WEBPACK_IMPORTED_MODULE_1__["default"], {
        fontFace: "default",
        onClick: () => {
          setVisible(false);
          setSearch('');
          // onFontChoice('system', false);
          onFontChoice('system', 'DM Sans, sans-serif');
        },
        label: inheritDefault ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Inherit', 'solace') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Default', 'solace')
      })));
    }
    Object.keys(groups).map(key => {
      if (systemFonts && key !== 'System') {
        return null;
      }
      if (groups[key].length > 0) {
        options.push((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
          className: "font-group-header",
          key: key
        }, key));
      }
      groups[key].map((font, index) => {
        if (index < loadUntil) {
          options.push((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
            key: font,
            className: font === selected ? 'selected' : ''
          }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_FontPreviewLink_js__WEBPACK_IMPORTED_MODULE_1__["default"], {
            delayLoad: false,
            label: font,
            fontFace: maybeGetTypekit(font),
            onClick: () => {
              onFontChoice(key, font);
              setVisible(false);
              setSearch('');
            }
          })));
        }
        return font;
      });
      return key;
    });
    if (loadUntil < options.length) {
      options.push((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
        className: "load-more",
        key: "load-more"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)((react_visibility_sensor__WEBPACK_IMPORTED_MODULE_2___default()), {
        offset: {
          top: 20
        },
        minTopValue: 1,
        partialVisibility: true,
        onChange: isVisible => {
          if (isVisible) {
            setLoadUntil(loadUntil + 30);
          }
        }
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Icon, {
        icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_5__["default"]
      }))));
    }
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "popover-content"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "popover-header"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "search"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
      placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Search', 'solace') + '...',
      value: search,
      onChange: e => {
        setSearch(e);
        setLoadUntil(20);
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: "#close-font",
      className: "close-font-selector",
      onClick: e => {
        e.preventDefault();
        e.stopPropagation();
        setVisible(false);
        setSearch('');
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Icon, {
      size: 21,
      icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_6__["default"]
    })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      className: "solace-fonts-list"
    }, options.length ? options : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "no-result",
      key: "no-results"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('No results.', 'solace')))));
  };
  // eslint-disable-next-line max-len
  const defaultFontface = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
  const font = maybeGetTypekit(selected);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "solace-font-family-control"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "customize-control-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Font Family', 'solace')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    className: "font-family-selector-toggle",
    isSecondary: true,
    onClick: () => {
      setVisible(true);
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "ff-name"
  }, selected || (inheritDefault ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Inherit', 'solace') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Default', 'solace'))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "ff-preview",
    style: {
      fontFamily: font || defaultFontface
    }
  }, "Abc"), visible && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Popover, {
    position: "bottom left",
    onFocusOutside: () => {
      setVisible(false);
      setSearch('');
    }
  }, fonts ? getFontList() : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('In Progress', 'solace'))));
};
FontFamilySelector.propTypes = {
  onFontChoice: (prop_types__WEBPACK_IMPORTED_MODULE_7___default().func).isRequired,
  maybeGetTypekit: (prop_types__WEBPACK_IMPORTED_MODULE_7___default().func).isRequired,
  inheritDefault: (prop_types__WEBPACK_IMPORTED_MODULE_7___default().bool).isRequired,
  selected: prop_types__WEBPACK_IMPORTED_MODULE_7___default().oneOfType([(prop_types__WEBPACK_IMPORTED_MODULE_7___default().string), (prop_types__WEBPACK_IMPORTED_MODULE_7___default().bool)])
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (FontFamilySelector);

/***/ }),

/***/ "./assets/apps/customizer-controls/src/font-family/FontPreviewLink.js":
/*!****************************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/font-family/FontPreviewLink.js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_1__);


const FontPreviewLink = ({
  fontFace,
  onClick,
  label
}) => {
  const style = {
    fontFamily: fontFace + ', sans-serif'
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    className: "dropdown-font-list",
    href: "#font-list",
    onClick: e => {
      e.stopPropagation();
      onClick();
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "solace-font-family"
  }, label || fontFace), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "solace-font-preview",
    style: style
  }, "Abc"));
};
FontPreviewLink.propTypes = {
  fontFace: (prop_types__WEBPACK_IMPORTED_MODULE_1___default().string).isRequired,
  onClick: (prop_types__WEBPACK_IMPORTED_MODULE_1___default().func).isRequired,
  label: (prop_types__WEBPACK_IMPORTED_MODULE_1___default().string)
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (FontPreviewLink);

/***/ })

}]);
//# sourceMappingURL=ca29e9e505ec82e3d3ec.js.map