"use strict";
(self["webpackChunksolace"] = self["webpackChunksolace"] || []).push([["assets_apps_components_src_Common_ColorPickerFix_js"],{

/***/ "./assets/apps/components/src/Common/ColorPickerFix.js":
/*!*************************************************************!*\
  !*** ./assets/apps/components/src/Common/ColorPickerFix.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ColorPickerFix)
/* harmony export */ });
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);

const dataToColors = (oldColors, {
  source,
  valueKey,
  value
}) => {
  if (source === 'hex') {
    return {
      source,
      [source]: value
    };
  }
  return {
    source,
    ...{
      ...oldColors[source],
      ...{
        [valueKey]: value
      }
    }
  };
};
const isValueEmpty = data => {
  if (data.source === 'hex' && data.hex === undefined) {
    return true;
  }
  if (data.source === 'hsl' && (data.h === undefined || data.s === undefined || data.l === undefined)) {
    return true;
  }

  /**
   * Check that if source is `rgb`:
   * `r`, `g` or `b` properties are not undefined
   * OR (||) `h`, `s`, `v` or `a` properties are not undefined
   * OR (||) `h`, `s`, `l` or `a` properties are not undefined
   *
   * before it was checking with NOT(!) statement witch for `0` (bool|int) values returns `true`
   * this is a typecasting issue only visible for hex values that derive from #000000
   */
  return data.source === 'rgb' && (data.r === undefined || data.g === undefined || data.b === undefined) && (data.h === undefined || data.s === undefined || data.v === undefined || data.a === undefined) && (data.h === undefined || data.s === undefined || data.l === undefined || data.a === undefined);
};
class ColorPickerFix extends _wordpress_components__WEBPACK_IMPORTED_MODULE_0__.ColorPicker {
  handleInputChange(data) {
    switch (data.state) {
      case 'reset':
        this.resetDraftValues();
        break;
      case 'commit':
        const colors = dataToColors(this.state, data);
        if (!isValueEmpty(colors)) {
          this.commitValues(colors);
        }
        break;
      case 'draft':
        this.setDraftValues(dataToColors(this.state, data));
        break;
    }
  }
}

/***/ })

}]);
//# sourceMappingURL=0a48c009c7f636ea41bd.js.map